<?php
/**
 * DocLister abstract extender class
 *
 * @license GNU General Public License (GPL), http://www.gnu.org/copyleft/gpl.html
 * @author Agel_Nash <Agel_Nash@xaker.ru>
 *
 */
abstract class extDocLister
{
    /**
     * Объект унаследованный от абстрактоного класса DocLister
     * @var DocLister
     * @access protected
     */
    protected $DocLister;

    /**
     * Объект DocumentParser - основной класс MODX
     * @var DocumentParser
     * @access protected
     */
    protected $modx;

    /**
     * Массив параметров экстендера полученных при инициализации класса
     * @var array
     * @access protected
     */
    protected $_cfg = array();

    /**
     * Запуск экстендера.
     * Метод определяющий действия экстендера при инициализации
     */
    abstract protected function run();

    /**
     * Конструктор экстендеров DocLister
     *
     * @param DocLister $DocLister объект класса DocLister
     */
    public function __construct($DocLister){
        if ($DocLister instanceof DocLister) {
            $this->DocLister = $DocLister;
            $this->modx = $this->DocLister->getMODX();
        }
    }
    /**
     * Вызов экстенедара с параметрами полученными в этой функции
     *
     * @param DocLister $DocLister объект класса DocLister
     * @param mixed $config, ... неограниченное число параметров (используются для конфигурации экстендера)
     * @return mixed ответ от экстендера (как правило это string)
     */
    final public function init($DocLister)
    {
        $flag = false;
        if ($DocLister instanceof DocLister) {
            $this->DocLister = $DocLister;
            $this->modx = $this->DocLister->getMODX();
            $this->checkParam(func_get_args());
            $flag = $this->run();
        }
        return $flag;
    }

    /**
     * Установка первоначального конфига экстендера
     *
     * @param array $args конфиг экстендера c массивом параметров
     */
    final protected function checkParam($args)
    {
        if (isset($args[1])) {
            $this->_cfg = $args[1];
        }
    }

    /**
     * Получение информации из конфига экстендера
     *
     * @param string $name имя параметра в конфиге экстендера
     * @param mixed $def значение по умолчанию, если в конфиге нет искомого параметра
     * @return mixed значение из конфига экстендера
     */
    final protected function getCFGDef($name, $def)
    {
        return isset($this->_cfg[$name]) ? $this->_cfg[$name] : $def;
    }
}