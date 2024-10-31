<?php


class Page
{

    protected $page_max = 0;
    protected $total = 0;
    protected $limit = 10;
    protected $p = 'p';
    protected $split = '';

    public function __construct($total, $limit)
    {
        $this->page_max = ceil($total / $limit);
        $this->total = $total;
        $this->limit = $limit;
    }

    /**
     * 显示页码
     */
    public function show()
    {

        $page_max = $this->page_max;


        $param = $this->getParam();
        // var_dump($param);
        $p = isset($_GET[$this->p]) ? intval($_GET[$this->p]) : 1;
        $p = $p < 1 ? 1 : $p;
        $p = $p > $page_max ? $page_max : $p;

        echo '<div class="pagination" >';

        if ($p > 1) {
            $last_page = $p - 1;
            echo "<a href='?{$this->p}=$last_page{$param}'><span class='pageNum'><div class='arrow pagination-left-arrow'></div></span></a>";
            echo $this->split;
        }

        if ($p == 1) {
            echo '<span class="pageNum active">1</span>';
        } else {
            echo "<a href='?{$this->p}=1{$param}'><span class='pageNum'>1</span></a>";
        }
        echo $this->split;

        $start = $this->getStart($p);
        $end = $this->getEnd($p);

        if ($start > 2) {
            echo '...';
            echo $this->split;
        }

        for ($i = $start; $i <= $end; $i++) {
            if ($p == $i) {
                echo "<span class='pageNum active'>" . $i . '</span>';
            } else {
                echo "<a href='?{$this->p}={$i}{$param}'><span class='pageNum'>" . $i . '</span></a>';
            }
            echo $this->split;
        }
        if ($end < $page_max - 1) {
            echo '...';
            echo $this->split;
        }

        if ($page_max > 1) {
            if ($p == $page_max) {
                echo "<span class='pageNum'>$page_max</span>";
            } else {
                echo "<a href='?{$this->p}={$page_max}{$param}'><span class='pageNum'>$page_max</span></a>";
            }
            echo $this->split;
        }

        if ($p < $page_max) {
            $next_page = $p + 1;
            echo "<a href='?{$this->p}=$next_page{$param}'><span class='pageNum'><div class='arrow pagination-right-arrow'></div></span></a>";
            echo $this->split;
        }

        echo '<span class="pageNum">';
        echo $this->total . ' 条数据,当前第 ' . $p . ' 页,共 ' . $page_max . ' 页';
        echo '</span>';

        echo '</div>';
    }

    /**
     * 自定义页码参数
     * @param $val
     */
    public function setP($val)
    {
        $this->p = $val;
    }

    /**
     * 获取queryString
     * @return string
     */
    private function getParam()
    {
        $query_str = $_SERVER['QUERY_STRING'];
        if (!$query_str) {
            return '';
        }
        $query_arr = explode('&', $query_str);

        $param_arr = array();
        foreach ($query_arr as $query_item) {
            $item = explode('=', $query_item);
            $key = $item[0];
            $value = $item[1];
            $param_arr[$key] = $key . '=' . $value;
        }

        unset($param_arr[$this->p]);
        if (empty($param_arr)) {
            return '';
        }
        $param = implode('&', $param_arr);
        return '&' . $param;
    }

    /**
     * 获取起始页码
     * @param int $p
     * @return int
     */
    private function getStart($p)
    {
        if ($p < 9) {
            return 2;
        } else {
            return $p > $this->page_max - 8 ? $this->page_max - 8 : $p;
        }
    }

    /**
     * 获取最后一页
     * @param int $p
     * @return int
     */
    private function getEnd($p)
    {
        if ($p < 9) {
            $end = 9;
            return $end > $this->page_max - 1 ? $this->page_max - 1 : $end;
        } else {
            $end = $p + 7;
            return $end > $this->page_max - 1 ? $this->page_max - 1 : $end;
        }
    }
}
