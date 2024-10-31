<?php $tbk_data = get_option('tbk_data');
$sort = (!isset($_GET['sort']) || $_GET['sort'] == '') ? 0 : $_GET['sort'];
$column = (!isset($_GET['column']) || $_GET['column'] == '') ? 0 : $_GET['column'];
$paging = (!isset($_GET['paging']) || $_GET['paging'] == '') ? 1 : $_GET['paging'];
if ($tbk_data['blog_header'] == '0') { ?>
    <!DOCTYPE html>
    <html>

    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title><?php echo $tbk_data['template']['title']; ?></title>
        <meta name="keywords" content="<?php echo $tbk_data['template']['keywords']; ?> ">
        <meta name="description" content="<?php echo $tbk_data['template']['description']; ?> ">
        <link rel="shortcut icon" href="<?php echo plugins_url('/images/favicon.ico', __FILE__); ?>">
        <link href="<?php echo plugins_url('/css/index.css', __FILE__); ?>" rel="stylesheet">
    </head>

    <body>
        <div data-v-7becb7b9="" class="nav-header-wrapper">
            <div data-v-7becb7b9="" class="nav-header">
                <div data-v-7becb7b9="" class="nav-header-logo"></div>
                <div data-v-7becb7b9="" class="icon nav-header-tv-icon"></div>
                <div data-v-7becb7b9="" class="nav-header-mainsite"><a href="/">主站</a></div>
                <div data-v-7becb7b9="" class="nav-header-search-bar-wrapper">
                    <input data-v-7becb7b9="" placeholder="快搜索喜欢的商品吧!!!" type="text" id="keyword" class="nav-header-search-bar">
                    <div data-v-7becb7b9="" class="icon search-icon">
                        <a data-v-7becb7b9="" href="javascript:void(0);" onclick="query()" class="search-link"></a>
                    </div>
                </div>
                <script type="text/javascript">
                    function query() {
                        var input = document.getElementById("keyword");
                        if (!input.value) {
                            return false;
                        } else {
                            window.location.href = "<?php echo jiutu_tbk_current_url(); ?>?keyword=" + input.value;
                        }
                    }
                </script>
                <!-- <div data-v-7becb7b9="" class="user-info">
                    <a data-v-7becb7b9="" target="_blank" href="https://account.bilibili.com/site/home.html" class="user-center-link">
                        <div data-v-7becb7b9="" class="profile-img" style="background-image: url(&quot;https://i0.hdslb.com/bfs/kfptfe/floor/vanec724231fc0804bdcaffa88260a8ec2af.jpg&quot;);"></div>
                    </a>
                </div> -->
                <!-- <div data-v-7becb7b9="" class="order-and-icon-wrapper">
                    <div data-v-7becb7b9="" class="icon order-icon"></div>
                    <div data-v-7becb7b9="" class="order-center">订单中心</div>
                </div> -->
            </div>
        </div>
    <?php } else {
    wp_enqueue_style('qingdongcss1', plugins_url('/css/index.css', __FILE__));
    get_header();
} ?>

    <div class="selector-wrapper">
        <div class="wrapper type-selector-wrapper">
            <div class="title">栏目:</div>
            <div class="selector-content">
                <ul class="type-list">
                    <?php foreach ($tbk_data['menu'] as $key => $value) { ?>
                        <li class="current-type">
                            <a href="?sort=<?php echo $key; ?>">
                                <span class="<?php echo ($sort == $key && isset($_GET['sort'])) ? 'active' : ''; ?>"> <?php echo $value['top_menu']; ?></span>
                            </a>
                        </li>
                    <?php }; ?>
                </ul>
            </div>
        </div>
        <div class="wrapper type-selector-wrapper">
            <div class="title type-title">分类:</div>
            <div class="selector-content">
                <ul class="type-list">
                    <?php
                    if (!isset($tbk_data['menu'][$sort])) { ?>
                        <li class="current-type">
                            <span class="">此栏目没有商品分类信息!!</span>
                        </li>
                        <?php  } else {
                        foreach ($tbk_data['menu'][$sort]['submenu'] as $key => $value) { ?>
                            <li class="current-type ">
                                <a href="?sort=<?php echo $sort; ?>&column=<?php echo $key; ?>">
                                    <span class="<?php echo ($column == $key && isset($_GET['sort'])) ? 'active' : ''; ?>"><?php echo $value['submenu_title']; ?> </span>
                                </a>
                            </li>
                        <?php }; ?>
                    <?php } ?>
                </ul>
            </div>
        </div>
        <?php if ($tbk_data['suggestion'] == '1') { ?>
            <div class="wrapper order-selector-wrapper">
                <div class="selector-content" style="text-align: center;">
                    <ul class="order-list">
                        <?php jiutu_taoke_get_suggestion($tbk_data, $sort, $column); ?>
                    </ul>
                </div>
            </div>
        <?php } ?>
    </div>
    <div class="project-list-wrapper">
        <div class="project-list">
            <?php $total_results = jiutu_taoke_get_goods($tbk_data, $sort, $column, $paging); ?>
        </div>
    </div>
    <div class="whole-pagination-wrapper">
        <div class="pagination-wrapper">
            <?php jiutu_taoke_page($total_results, $tbk_data['page_size']);
            ?>
        </div>
    </div>
    <div class="toolbar-wrapper">
        <div class="left-slider-wrapper">
            <a target="_blank" href="https://wpa.qq.com/wpa_jump_page?v=3&uin=<?php echo $tbk_data['qq']; ?>&site=qq&menu=yes" class="service-wrapper">
                <div class="service-icon"></div>
                <div class="toolbar-title">客服</div>
            </a>
        </div>
    </div>
    <?php if ($tbk_data['blog_header'] == '0') { ?>
        <div class="footer">
            <div class="footer-wrp">
                <div class="border"></div>
                <div class="footer-cnt clearfix">
                    <div class="partner">

                        <div class="block left" style="margin: 0px 68px 0px 115px; line-height: 24px; float: none;">
                            <div class="isShowDomain">
                                <?php echo $tbk_data['template']['foot']; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>

    </html>
<?php } else {
        get_footer();
    } ?>