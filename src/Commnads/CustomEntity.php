<?php

namespace Ci4Common\Commands;

use Ci4Orm\Entities\ORM;
use CodeIgniter\CLI\CLI;
use CodeIgniter\CLI\GeneratorCommand;
use Exception;

class CustomEntity extends GeneratorCommand
{
    /**
     * The group the command is lumped under
     * when listing commands.
     *
     * @var string
     */
    protected $group = 'Generators';

    /**
     * The Command's name
     *
     * @var string
     */
    protected $name = 'make:orm-entity';

    /**
     * The Command's short description
     *
     * @var string
     */
    protected $description = 'Create entity-orm class';

    /**
     * The Command's usage
     *
     * @var string
     */
    protected $usage = 'make:orm-entity [arguments] [options]';

    /**
     * The Command's arguments.
     *
     * @var array
     */
    protected $arguments = [
        'yml' => 'Yaml entity file name',
    ];

    /**
     * Use classes
     *
     * @var array
     */
    protected $useClasses = [];

    /**
     * The Command's options.
     *
     * @var array
     */
    protected $options = [];

    protected function getClassName(): string
    {
        // If the class name is required you need to have this.
        // Otherwise, you can safely remove this method.

        $className = parent::getClassName();

        if (empty($className)) {
            $className = CLI::prompt(lang('CLI.generateClassName'), null, 'required');
        }

        return $className;
    }

    protected function getNamespacedClass(string $rootNamespace, string $class): string
    {
        return $rootNamespace . 'Entities\/' . $class;
    }

    protected function getTemplate(): string
    {
        $content = $this->contentTemplate();
        $parentTemplate = $this->classTemplate($this->getClassName());

        $template = str_replace("@content\n", $content, $parentTemplate);

        return $template;
    }

    private function addUseClass($useClass)
    {
        $this->useClasses[] = $useClass;
        $this->useClasses = array_unique($this->useClasses, SORT_STRING);
    }

    protected function contentTemplate()
    {
        $entityProps = ORM::getProps('App\\Entities\\' . $this->getClassName());
        if (empty($entityProps)) {
            echo "ERROR!! Entity mapping not found";
            die();
        }
        $properties = [];
        $functions = [];
        foreach ($entityProps['props'] as $field => $prop) {
            $value =  '  = null;';
            $nullable =  '?';
            $type = $prop['type'];

            if (
                $field != 'Created' &&
                $field != 'CreatedBy' &&
                $field != 'Modified' &&
                $field != 'ModifiedBy'
            ) {
                if ($field == $entityProps['primaryKey']) {
                    $value = ' = 0;';
                    $nullable = '';
                }

                if ($prop['isEntity']) {
                    $type = explode("\\", $type)[2];
                    if ($prop['relationType'] == 'many_to_one') {
                        $this->addUseClass("Ci4Orm\Entities\EntityList");
                        $type = 'EntityList';
                    }
                }


                $doc = "\t/**\n\t * @var $type \n\t */\n";
                $prop = "\tprivate " . $nullable . $type . " $" . $field . $value . "\n";
                $properties[] = $doc . $prop;

                $getDoc = "\n\t/**\n\t * @return ?$type \n\t */";
                $getFn  = "\n\tprotected function get" . $field . "(): ?$type \n\t{\n\t\t" . 'return $this->' . $field . ";\n\t}\n";
                $get = $getDoc . $getFn;

                $setDoc = "\n\t/**\n\t * @param $type " . "$" . $field . "\n\t * @return $" . "this" . " \n\t */";
                $setFn = "\n\tprotected function set" . $field . "($type $$field)\n\t{\n\t\t" . '$this->' . $field . " = $$field;\n\t\t" . 'return $this' . ";\n\t}";
                $set = $setDoc . $setFn;
                $functions[] =  $get . $set;
            }
        }
        $content = implode("\n", $properties);
        $content .= "\n" . implode("\n", $functions);
        return $content;
    }

    protected function appendUseClasses()
    {
        $use = '';

        foreach ($this->useClasses as $useClass) {
            $use .= "use " . $useClass . ";\n";
        }
        return $use;
    }

    protected function classTemplate($class)
    {
        $classTemplate = "<?php\n\n";
        $classTemplate .= "namespace App\Entities;\n\n";
        $classTemplate .= $this->appendUseClasses();
        $classTemplate .= "\nclass $class extends BaseEntity\n";
        $classTemplate .= "{\n";
        $classTemplate .= "@content\n";
        $classTemplate .= "\n}\n";
        return $classTemplate;
    }
}
