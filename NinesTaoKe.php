<?php
/*
Plugin Name: 淘宝客
Plugin URI: https://wordpress.org/plugins/nines-taoke/
Description: 淘宝客插件(通过淘宝开发平台->淘宝客Api 所获取淘客商品信息并展示在一个页面上)
Version:2.8.2
Author: 不问归期_
Author URI: https://www.aliluv.cn/
*/
require_once plugin_dir_path(__FILE__) . 'vendor/autoload.php';
require_once plugin_dir_path(__FILE__) . 'inc/classes/setup.class.php';

// us/e ETaobao\Factory;

// $config = [
// 	'appkey' => '27972726',
// 	'secretKey' => 'c9f34cb87a14239fe77486758e7baa00',
// ];

// $app = ETaobao\Factory::Tbk($config);
// $param = [
// 	// 'fields' => 'num_iid,title,pict_url,small_images,reserve_price,zk_final_price,user_type,provcity,item_url,seller_id,volume,nick',
// 	'q' => '蚊香',
// 	'adzone_id' => '109539200255',
// ];
// // $res = $app->item->get($param);
// $res = $app->dg->materialOptional($param);
// print_r($res);
// return;


if (class_exists('CSF')) {
	$prefix = 'tbk_data';
	CSF::createOptions($prefix, array(
		'framework_title'   => '淘宝客 ' . '<small> 这是说明</small>',
		'show_search'       => false,
		'theme'             => 'light',
		'menu_title'        => '淘宝客',
		'menu_icon'         => 'dashicons-cart',
		'menu_slug'         => 'jiutu_tbk',
		'footer_text'       => '任何使用问题可联系QQ:781272314',
		'nav'               => 'inline',
		'show_reset_all'    => false,
		'show_reset_section' => false,
		'show_all_options'  => false,
	));
	CSF::createSection($prefix, array(
		'title'  => '商品菜单配置',
		'fields' => array(
			array(
				'id'        => 'menu',
				'type'      => 'group',
				'fields'    => array(
					array('id' => 'top_menu', 'type' => 'text', 'title' => '顶级菜单'),
					array(
						'id'    => 'image',
						'type'  => 'media',
						'title' => '菜单图片',
						'library' => 'image',
						'url'   => false,
						'button_title' => '选择',
						'desc'  => '目前前端暂不作显示菜单图片,也可以先配置!万一后面用上了呢'
					),
					array(
						'id'        => 'submenu',
						'type'      => 'repeater',
						'title'     => '子菜单',
						'fields'    => array(
							array(
								'id'    => 'submenu_title',
								'type'  => 'text',
							),

						),
					),
				),
				'default'   => array(
					array(
						'top_menu'     => '女装',
						'submenu' => array(
							array('submenu_title' => '衬衫'),
							array('submenu_title' => 'T恤'),
							array('submenu_title' => '风衣'),
							array('submenu_title' => '马甲裙'),
							array('submenu_title' => '牛仔裙'),
							array('submenu_title' => '学院风'),
							array('submenu_title' => '仙女系'),
							array('submenu_title' => '阔腿裤'),
							array('submenu_title' => '破洞裤'),
							array('submenu_title' => '打底裤'),
							array('submenu_title' => '小脚裤'),
							array('submenu_title' => '9分裤'),
							array('submenu_title' => '背带裤'),
							array('submenu_title' => '紧身牛仔'),
							array('submenu_title' => '优雅长款'),
							array('submenu_title' => '显高短款'),
						),
					),
					array(
						'top_menu'     => '男装',
						'submenu' => array(
							array('submenu_title' => '韩风'),
							array('submenu_title' => '落肩'),
							array('submenu_title' => '条纹'),
							array('submenu_title' => '街头'),
							array('submenu_title' => '嘻哈'),
							array('submenu_title' => '国潮 '),
							array('submenu_title' => '铆钉'),
							array('submenu_title' => '破洞'),
							array('submenu_title' => '卫衣'),
							array('submenu_title' => '九分'),
							array('submenu_title' => '七分'),
							array('submenu_title' => '衬衫'),
							array('submenu_title' => 'T恤'),
							array('submenu_title' => '长款T恤 '),
							array('submenu_title' => '休闲裤'),
							array('submenu_title' => '运动裤 '),

						),
					),
					array(
						'top_menu'     => '内衣',
						'submenu' => array(
							array('submenu_title' => '少女'),
							array('submenu_title' => '蕾丝'),
							array('submenu_title' => '睡裙'),
							array('submenu_title' => '抹胸'),
							array('submenu_title' => '薄款'),
							array('submenu_title' => '真丝'),
							array('submenu_title' => '运动'),
							array('submenu_title' => '胸贴'),
							array('submenu_title' => '隐形'),
							array('submenu_title' => '情侣'),
							array('submenu_title' => '家居服'),
							array('submenu_title' => '女内裤'),
							array('submenu_title' => '男内裤'),
							array('submenu_title' => '水晶袜'),
							array('submenu_title' => '无钢圈'),
							array('submenu_title' => '平角裤'),
							array('submenu_title' => '七了个三'),
							array('submenu_title' => '二次元'),

						),
					),
				),
			),
		)
	));
	CSF::createSection($prefix, array(
		'title'  => '插件设置',
		'fields' => array(
			array(
				'id'          => 'view_page',
				'type'        => 'select',
				'title'       => '商品页面',
				'options'     => 'pages',
				'query_args'  => array(
					'posts_per_page' => -1 // for get all pages (also it's same for posts).
				),
				'desc'  => '选择一个展示商品的页面. <a href="post-new.php?post_type=page">新增!!</a>访问此页面即可显示数据'
			),
			array(
				'id'      => 'page_size',
				'type'    => 'spinner',
				'title'   => '页商品数量',
				'min'     => 1,
				'max'     => 100,
				'default' => 16,
				'desc'  => '页大小、默认16、1~100'
			),
			array(
				'id'    => 'qq',
				'title' => '侧边客服QQ',
				'type'  => 'text',
				'desc'  => '这个功能是不是多余了',
			),

			array(
				'id'      => 'blog_header',
				'type'    => 'switcher',
				'title'   => '使用博客主题导航',
				'default' => true,
				'desc'  => '默认启用、但启用后可能会被博客主题的css样式覆盖影响导致页面数据错乱!所有建议·禁用·',
			),

			array(
				'id'     => 'template',
				'type'   => 'fieldset',
				'dependency' => array('blog_header', '==', false),
				'desc'  => '页面SEO优化信息',
				'fields' => array(
					array(
						'id'    => 'title',
						'title' => '页面标题',
						'type'  => 'text',
					),
					array(
						'id'    => 'keywords',
						'title' => '页面关键词',
						'type'  => 'text',
						'desc'      => '使用，分割'
					),
					array(
						'id'    => 'description',
						'title' => '页面介绍',
						'type'  => 'textarea',
					),
					array(
						'id'    => 'foot',
						'title' => '底部介绍',
						'type'  => 'textarea',
					),
				),
			),


			array(
				'id'      => 'suggestion',
				'type'    => 'switcher',
				'title'   => '启用 联想词',
				'default' => true,
				'desc'  => ' (此功能使用大淘客的api接口,如果开启请到下方 ·商品数据来源· 切换[大淘客]配置好应用app_key及app_secret)',
			),
			array(
				'id'         => 'data_sources',
				'type'       => 'button_set',
				'title'      => '商品数据来源',
				'options'    => array(
					'alimama'  => '淘宝联盟',
					'dataoke' => '大淘客',
				),
				'default'    => 'alimama'
			),
			array(
				'id'     => 'alimama',
				'type'   => 'fieldset',
				'dependency' => array('data_sources', '==', 'alimama'),
				'fields' => array(
					array(
						'id'    => 'app_key',
						'title' => 'App Key',
						'type'  => 'text',
					),
					array(
						'id'    => 'app_secret',
						'title' => 'App Secret',
						'type'  => 'text',
					),
					array(
						'id'    => 'pid',
						'title' => 'Pid',
						'type'  => 'text',
					),

					array(
						'type'    => 'subheading',
						'style'   => 'success',
						'content' => '以上三个配置项、如果不懂请查看此链接 安装步骤方法进行获取: https://wpapi.aliluv.cn/141<br/>
									  1、如果App key是刚通过审核的、淘宝联盟平台需要一天左右时间刷新服务器才能正常获取到商品信息<br/>
									  2、本插件需要用到淘宝官方接口、没有权限请自行申请(如果没有权限会有提示,英文的、、看不懂自行翻译可好??) -><a href="https://open.taobao.com/api.htm?docId=35896&docType=2&scopeId=16516" class="alert-link">去申请</a><br/>
									  3、其中pid必须是淘宝联盟->网站推广位 的pid(没有这个推广位的pid请申请),其它位置的pid将获取不到商品数据 ',
					),
				),
			),

			array(
				'id'     => 'dataoke',
				'type'   => 'fieldset',
				'dependency' => array('data_sources', '==', 'dataoke'),
				'fields' => array(
					array(
						'id'    => 'app_key',
						'title' => 'APP_KEY',
						'type'  => 'text',
					),
					array(
						'id'    => 'app_secret',
						'title' => 'APP_SECRET',
						'type'  => 'text',
					),

					array(
						'type'    => 'subheading',
						'style'   => 'success',
						'content' => '前往 <a target="_blank" href="https://www.dataoke.com/kfpt/apply-l.html">大淘客</a> 获取应用信息填写上方',
					),
				),
			),
		)
	));

	CSF::createSection($prefix, array(
		'title'  => '使用说明',
		'fields' => array(
			array(
				'type'     => 'callback',
				'function' => 'jiutu_tbk_instructions',
			),
		)
	));
}
function jiutu_tbk_instructions()
{ ?>
	1、演示地址: https://wpapi.aliluv.cn/shop </br>
	2、插件设置帮助:https://wpapi.aliluv.cn/141/ </br>
	<h3>先这样吧,有问题 到 https://wpapi.aliluv.cn/141 评论留言..</h3>

	<?php }

// add_action('init', function () {
// register_post_type('goods', array(
// 'public' => true,
// 'show_ui' => false,
// 'has_archive' => true,
// 'supports' => array()
// ));
// });
add_filter('template_include', function ($template_path) {
	// echo '<pre>';

	if (get_post_type() == 'page') {
		$tbk_data = get_option('tbk_data');
		if (get_the_ID() == (int)$tbk_data['view_page']) {
			//默认模版
			return plugin_dir_path(__FILE__) . 'templates/default/index.php';
		}
	}
	// echo '</pre>';
	return $template_path;
}, 1);

function jiutu_taoke_get_menu_keyword($menu, $sort, $column, $suggestion = false)
{
	if (array_key_exists($sort, $menu['menu'])) {
		$top_menu = $menu['menu'][$sort]['top_menu'];
	} else {
		$top_menu = '';
		$sort = 0;
	}
	if (array_key_exists($column, $menu['menu'][$sort]['submenu'])) {
		$submenu = $menu['menu'][$sort]['submenu'][$column]['submenu_title'];
	} else {
		$submenu = '';
	}
	if ($suggestion) {
		return  $submenu;
	}
	return $top_menu . $submenu;
}

function jiutu_taoke_get_goods($data = array(), $sort = 0, $column = 0, $page = 1)
{
	$data_sources = $data['data_sources'];
	$keyword = (!isset($_GET['keyword']) || $_GET['keyword'] == '') ? '' : $_GET['keyword'];
	if (!$keyword) {
		$keyword = jiutu_taoke_get_menu_keyword($data, $sort, $column);
	}


	if ($data_sources == 'alimama') {
		$alimama = $data['alimama'];
		$app = ETaobao\Factory::Tbk(array(
			'appkey' => $alimama['app_key'],
			'secretKey' => $alimama['app_secret'],
		));

		$resp = $app->dg->materialOptional(array(
			'page_size' => $data['page_size'],
			'page_no' => $page,
			'q' => $keyword,
			'has_coupon' => 'true',
			'adzone_id' => jiutu_taoke_get_pid($alimama['pid'])
		));
		$res = $resp->result_list->map_data;
		if (!empty($resp->msg)) {
			echo '<script language="javascript">alert("' . $resp->msg . '");history.go(-1);</script>';
			return 1;
		}
		foreach ($res as $key => $val) {
			$val->description = $val->item_description ? $val->item_description : $val->shop_title; ?>
			<div class="project-list-item">
				<a href=" <?php echo $val->coupon_share_url; ?>" target=" _blank">
					<div class="project-list-item-img" style="background-image: url(&quot;<?php echo $val->pict_url; ?>&quot;);"></div>
					<div class="project-list-item-detail">
						<div class="project-list-item-title" style="-webkit-box-orient: vertical;"><?php echo $val->title; ?></div>
						<div class="project-list-item-time"><span class="icon time-icon"></span><?php echo $val->coupon_start_time; ?> <span> / 已售<?php echo $val->volume; ?>件</span>
						</div>
						<div class="project-list-item-address"><span class="icon address-icon"></span> <span class="city-name"><?php echo $val->provcity; ?></span> <span class="venue-name-and-address"><?php echo $val->description; ?></span></div>
						<div class="project-list-item-price">
							<div class="not-free"><span class="price-symbol">¥</span> <span class="price"><?php echo ($val->zk_final_price - $val->coupon_amount); ?></span>
								<span class="promo-item">领券:<?php echo $val->coupon_amount; ?>元</span>
								<?php if ($val->user_type == 1) { ?>
									<span class="promo-item">天猫</span>
								<?php } ?>
								<?php if ($val->real_post_fee == '0.00') { ?>
									<span class="promo-item">包邮</span>
								<?php } ?>
							</div>
						</div>
					</div>
				</a>
			</div>
		<?php }

		// print_r($resp);

		// 		$c = new TopClient;
		// 		$c->appkey = $alimama['app_key'];
		// 		$c->secretKey = $alimama['app_secret'];
		// 		$req = new TbkDgMaterialOptionalRequest;
		// 		$req->setPageSize($data['page_size']);
		// 		$req->setPageNo($page);
		// 		$req->setAdzoneId(jiutu_taoke_get_pid($alimama['pid']));
		// 		$req->setQ($keyword);
		// 		$req->setHasCoupon("true");
		// 		$resp = $c->execute($req);
		// 		if (!empty($resp->msg)) {
		// 			echo '<script language="javascript">
		// 	alert("' . $resp->msg . '");
		// 	history.go(-1);
		// </script>';
		// 			return false;
		// 		}
		return $resp->total_results;
	}

	/**
	 * 大淘客
	 *
	 * @var [type]
	 */
	if ($data_sources == 'dataoke') {
		$dataoke = $data['dataoke'];
		$client = new GetGoodsListSuperSearch();
		$client->setAppKey($dataoke['app_key']);
		$client->setAppSecret($dataoke['app_secret']);
		$client->setVersion('v1.3.0');

		$resp = $client->setParams(array(
			'type' => 2,
			'hasCoupon' => 1,
			'pageId' => $page,
			'pageSize' => $data['page_size'],
			'keyWords' => $keyword,
		))->request();
		$resp = json_decode($resp);
		if ($resp->code != 0) {
			echo '<script language="javascript">alert("' . $resp->msg . '");history.go(-1);</script>';
			return 1;
		}
		$res = $resp->data->list;
		foreach ($res as $key => $val) {
			$val->desc = $val->desc ? $val->desc : $val->shopName;
		?>
			<div class="project-list-item">
				<a href=" <?php echo $val->couponLink; ?>" target=" _blank">
					<div class="project-list-item-img" style="background-image: url(&quot;<?php echo $val->mainPic; ?>&quot;);"></div>
					<div class="project-list-item-detail">
						<div class="project-list-item-title" style="-webkit-box-orient: vertical;"><?php echo $val->title; ?></div>
						<div class="project-list-item-time"><span class="icon time-icon"></span><?php echo $val->couponStartTime; ?> <span> /30天销量:<?php echo $val->monthSales; ?>件</span>
						</div>
						<div class="project-list-item-address"><span class="icon address-icon"></span><?php echo $val->desc; ?></div>
						<div class="project-list-item-price">
							<div class="not-free"><span class="price-symbol">¥</span> <span class="price"><?php echo $val->actualPrice; ?></span>
								<span class="promo-item">领券:<?php echo $val->couponPrice; ?>元</span>
								<?php if ($val->shopType == 1) { ?>
									<span class="promo-item">天猫</span>
								<?php } else { ?>
									<span class="promo-item">淘宝</span>
								<?php } ?>
								<?php if ($val->yunfeixian == '1') { ?>
									<span class="promo-item">运费险</span>
								<?php } ?>
							</div>
						</div>
					</div>
				</a>
			</div>
		<?php }

		return $resp->data->totalNum;
	}
}

function jiutu_taoke_page($total_results = 100, $page_size = 16)
{
	require 'inc/page.php';
	$page = new Page($total_results, $page_size);
	$page->setP('paging');
	$page->show();
}



function jiutu_taoke_get_pid($pid = false)
{
	$res = explode('_', $pid);
	if (count($res) < 4) {
		return false;
	}
	return $res[3];
}

register_activation_hook(__FILE__, function () {
	jiutu_tbk_weixin_send('淘宝客插件被激活');
});

register_deactivation_hook(__FILE__, function () {
	jiutu_tbk_weixin_send('淘宝客插件被停用');
});
function jiutu_tbk_weixin_send($title, $content = '通知:')
{
	$request = new WP_Http;
	$request->request('https://wpapi.aliluv.cn/wp-admin/admin-ajax.php', array(
		'method' => 'GET',
		'body' => array(
			'action' => 'jiutu_weixin_send',
			'title' => $title,
			'content' => $content . date("Y-m-d H:i:s", time())
		)
	));
}



function jiutu_tbk_current_url($param = [])
{
	global $wp;
	$url = get_option('permalink_structure') == '' ? add_query_arg($wp->query_string, '', home_url($wp->request)) : home_url(add_query_arg([], $wp->request));
	$paramurl = http_build_query($param, '', '&');
	return (!$param) ? $url : $url . '?' . $paramurl;
}



/**
 * 获取 联想词
 *
 * @param   [type]  $q  [$q description]
 *
 * @return  [type]      [return description]
 */
function jiutu_taoke_get_suggestion($data, $sort, $column)
{
	$keyword = jiutu_taoke_get_menu_keyword($data, $sort, $column, true);
	$dataoke = $data['dataoke'];
	$client = new GetGoodsSearchSuggestion();
	$client->setAppKey($dataoke['app_key']);
	$client->setAppSecret($dataoke['app_secret']);
	$client->setVersion('v1.0.2');

	$resp = $client->setParams(array(
		'type' => 2,
		'keyWords' => $keyword,
	))->request();
	$resp = json_decode($resp);
	// var_dump($resp);
	if ($resp->code != 0) {
		echo '<script language="javascript">alert("' . $resp->msg . '");history.go(-1);</script>';
		return 1;
	}
	$res = $resp->data;
	foreach ($res as $key => $val) { ?>
		<li class="first city-item">
			<a href="?keyword=<?php echo $val->kw; ?>" class="active"><?php echo $val->kw; ?></a>
		</li>
<?php }
}
