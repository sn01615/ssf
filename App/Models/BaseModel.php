<?php


namespace App\Models;


use config\database;
use Illuminate\Container\Container;
use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Database\Connection;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Events\Dispatcher;
use LogicException;
use PDO;
use Ssf\Traits\GetInstances;

/**
 * @property Connection $db
 * @property Builder $tb
 * @property Builder $mtb
 */
abstract class BaseModel extends Model
{
    use GetInstances;

    private static $capsule;

    private $ssf_container;

    private $ssf_dispatcher;

    private $_ci;

    public function __construct()
    {
        if (PHP_VERSION_ID < 50400) {
            throw new LogicException("系统繁忙，请稍后重试");
        }
        if (!self::$capsule) {
            self::$capsule = new Capsule();

            $configs = database::getInstance()->config();

            if (!is_array($configs)) {
                throw new LogicException("系统繁忙，请稍后重试");
            }
            foreach ($configs as $name => $config) {
                self::$capsule->addConnection($config, $name);
            }

            $this->ssf_container = new Container();
            $this->ssf_dispatcher = new Dispatcher($this->ssf_container);

            // Set the event dispatcher used by Eloquent models... (optional)
            self::$capsule->setEventDispatcher($this->ssf_dispatcher);

            // Make this Capsule instance available globally via static methods... (optional)
            self::$capsule->setAsGlobal();

            // Setup the Eloquent ORM... (optional; unless you've used setEventDispatcher())
            self::$capsule->bootEloquent();

            self::$capsule->setFetchMode(PDO::FETCH_OBJ);
        }

        if (!$this->connection) {
            $this->connection = 'default';
        }

        if ($this->table == '') {
            $called_class = get_called_class();
            $called_class = explode('\\', $called_class);
            $called_class = end($called_class);
            $table = $this->humpToLine($called_class);
            if (substr($table, -6) == '_model') {
                $table = substr($table, 0, -6);
            }
            $this->setTable($table);
        }

        parent::__construct();
    }

    private function humpToLine(string $str): string
    {
        $str = lcfirst($str);
        $str = preg_replace_callback('/([A-Z]{1})/',
            function ($matches) {
                return '_' . strtolower($matches[0]);
            }, $str);
        return $str;
    }

    public function __get($key)
    {
        if ($key == 'db') {
            return Capsule::connection($this->connection);
        } elseif ($key == 'tb') {
            return Capsule::connection($this->connection)->table($this->table);
        } elseif ($key == 'mtb') {
            return Capsule::connection($this->connection)->table($this->table)->useWritePdo();
        }
        return parent::__get($key);
    }

    public function iInsertBatch($data)
    {
        $data = (array)$data;
        foreach ($data as &$item) {
            $item = (array)$item;
        }
        unset($item);
        return $this->tb->insert($data);
    }

    public function iUpdateOrInsert($where, $data)
    {
        $where = (array)$where;
        $data = (array)$data;
        return $this->mtb->updateOrInsert($where, $data);
    }

    public function iInsert($data)
    {
        $data = (array)$data;
        return $this->tb->insertGetId($data);
    }

    final protected function setConn($dbname)
    {
        $this->connection = $dbname;
    }
}