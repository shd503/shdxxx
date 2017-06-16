<?php

/**
 * 基于 Mysqli 的数据库操作类库
 * author Lee.
 * Last modify $Date: 2012-11-30 $
 */
class  M
{
    public $db;
    public $rs;

    public function __construct()
    {   //应用构造函数对类体中的属性进行初始化
        $this->db = MysqliDb::getDB();
    }


    public function cache_obj($cache)
    {
        $this->cache = $cache;
    }

    public function prepare($sql) //绑定sql
    {
        return $this->db->prepare($sql);
    }

    //析构函数：主要用来释放结果集和关闭数据库连接
    public function __destruct()
    {
        try {
            $this->close();
            $this->my_free();
        } catch (Exception $e) {
//            print $e;
        }

    }

    //释放结果集所占资源
    protected function my_free()
    {
//        @$this->rs->free();
        $this->rs = null;
    }

    //关闭数据库连接
    protected function close()
    {
        $this->db->close();
    }


    /**
     * 检查数据是否存在
     * @param string $tName 表名 || SQL 语句
     * @param string $condition 条件
     * @return bool 有返回 true,没有返回 false
     */
    public function IsExists($tName, $condition)
    {
        if (!is_string($tName) || !is_string($condition)) exit($this->getError(__FUNCTION__, __LINE__));
        if ($this->Total($tName, $condition)) {
            return true;
        } else {
            return false;
        }
    }


    /**
     * 执行单条 SQL 语句
     * @param string $sql SQL语句
     * @return bool
     */
    public function runSql($sql)
    {
        if (!is_string($sql)) exit($this->getError(__FUNCTION__, __LINE__));
        $bool = $this->db->query($sql);
//        $this->printSQLError($this->db);
        return $bool;

    }

    /**
     * 打印可能出现的 SQL 错误
     * @param Object $db 数据库对象句柄
     */

    private function printSQLError($db)
    {
        if ($db->errno) {
            echo("警告：SQL语句有误<br />错误代码：<font color='red'>{$db->errno}</font>；<br /> 错误信息：<font color='red'>{$db->error}</font>");
        }
    }

    /**
     * 事物回滚
     */
    public function rollback()
    {
        try {
            $this->db->rollback();
            $this->db->autocommit(true);
        } catch (Exception $e) {

        }

    }


    /**
     * 错误提示
     * @param string $fun
     * @return string
     */
    private function getError($fun, $line, $other = "")
    {
        return __CLASS__ . '->' . $fun . '() line<font color="red">' . $line . '</font> ERROR! ' . $other;
    }
}

?>