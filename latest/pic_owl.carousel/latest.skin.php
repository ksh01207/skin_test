<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
include_once(G5_LIB_PATH.'/thumbnail.lib.php');

//owl.carousel
add_stylesheet('<link rel="stylesheet" href="'.$latest_skin_url.'/owl/owl.carousel.css">', 0);
add_javascript('<script src="'.$latest_skin_url.'/owl/owl.carousel.js"></script>', 0);

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$latest_skin_url.'/style.css">', 0);

$thumb_width = (isset($options['thumb_w']) && $options['thumb_w'] > 0) ? $options['thumb_w'] : 210;
$thumb_height = (isset($options['thumb_h']) && $options['thumb_h'] > 0) ? $options['thumb_h'] : 150;
$img_h = round(($thumb_height / $thumb_width) * 100, 2);

//제목&내용 라인설정
$options['line'] = (isset($options['line']) && $options['line'] > 0) ? $options['line'] : 1;
$line_height = 22 * $options['line'];
if($options['line'] > 1) $line_height = $line_height + 4;

// owl 옵션
$nav_design = (isset($options['design']) && $options['design']) ? true : false;
$items = (isset($options['items']) && $options['items'] > 0) ? $options['items'] : 4;
$margin = (isset($options['margin']) && $options['margin'] > 0) ? $options['margin'] : 20;

$list_count = (is_array($list) && $list) ? count($list) : 0;

?>
<style>
<?php if($nav_design){ ?>
.prd_good_item .owl-dots .owl-dot{display:none}
.prd_good_item .relation_recopick .owl-nav{width:41px;*zoom:1;position:absolute;right:1px; top:-15px}
.prd_good_item .relation_recopick .owl-nav:after{content: "";display:block;clear:both}
.prd_good_item .relation_recopick .owl-nav .owl-prev{float:left;left:-42px;top:-10px;width: 40px;height: 38px;background: url(<?php echo $latest_skin_url;?>/img/widget_v_controls.png) no-repeat 0 0;background-size: 84px 118px;}
.prd_good_item .relation_recopick .owl-nav .owl-next{float:left;left:0px;top:-10px;width: 42px;height: 38px;background: url(<?php echo $latest_skin_url;?>/img/widget_v_controls.png) no-repeat 0 0;background-size: 84px 118px;background-position: -42px 0;}
<?php }else{ ?>
.prd_good_item .owl-dots .owl-dot{display:none}
.owl-carousel .owl-nav button.owl-prev{position: absolute;left: 0;top: 50%;text-indent: -9999em; display: block;width: 31px;height: 39px;margin-top: -20px;background:url(<?php echo $latest_skin_url;?>/img/btn_slider_left.png) no-repeat;}
.owl-carousel .owl-nav button.owl-next{position: absolute;right: 0;top: 50%;text-indent: -9999em; display: block;width: 31px;height: 39px;margin-top: -20px;background:url(<?php echo $latest_skin_url;?>/img/btn_slider_right.png) no-repeat;}
<?php } ?>

#divConcierge .post-subject { height:<?php echo $line_height;?>px; }
#divConcierge .img-wrap { padding-bottom:<?php echo $img_h;?>%; }

</style>

<div id="divConcierge" class="prd_good_item">
	<div class='relation_list relation_recopick'>
		<strong class='title'><a href="<?php echo get_pretty_url($bo_table); ?>"><?php echo $bo_subject ?></a></strong>
		<ul class='owl-carousel slider_column'>
			<?php
			for ($i=0; $i<$list_count; $i++) {
				$thumb = get_list_thumbnail($bo_table, $list[$i]['wr_id'], $thumb_width, $thumb_height, false, true);

				if($thumb['src']) {
					$img = $thumb['src'];
				} else {
					$img = G5_IMG_URL.'/no_img.png';
					$thumb['alt'] = '이미지가 없습니다.';
				}
				$img_content = '<img src="'.$img.'" alt="'.$thumb['alt'].'" >';
				if($list[$i]['wr_link1']){
					$wr_href = $list[$i]['wr_link1'];
					$wr_target = ' target="_blank"';
				}else{
					$wr_href = get_pretty_url($bo_table, $list[$i]['wr_id']);
				}

				if ($list[$i]['icon_secret']) $list[$i]['subject'] .= "<i class=\"fa fa-lock\" aria-hidden=\"true\"></i><span class=\"sound_only\">비밀글</span> ";

				if ($list[$i]['is_notice'])
					$list[$i]['subject'] = "<strong>".$list[$i]['subject']."</strong>";
				else
					;

				if ($list[$i]['icon_new']) $list[$i]['subject'] .= "<span class=\"new_icon\">N<span class=\"sound_only\">새글</span></span>";
				if ($list[$i]['icon_hot']) $list[$i]['subject'] .= "<span class=\"hot_icon\">H<span class=\"sound_only\">인기글</span></span>";

				// if ($list[$i]['link']['count']) { $list[$i]['subject'] .= "[{$list[$i]['link']['count']}]"; }
				// if ($list[$i]['file']['count']) { $list[$i]['subject'] .= "<{$list[$i]['file']['count']}>"; }

				// $list[$i]['subject'] .= $list[$i]['icon_reply']." ";
				// if ($list[$i]['icon_file']) $list[$i]['subject'] .= " <i class=\"fa fa-download\" aria-hidden=\"true\"></i>" ;
				// if ($list[$i]['icon_link']) $list[$i]['subject'] .= " <i class=\"fa fa-link\" aria-hidden=\"true\"></i>" ;

				if ($list[$i]['comment_cnt'])  $list[$i]['subject'] .= "<span class=\"lt_cmt\">".$list[$i]['wr_comment']."</span>";

				$list[$i]['wr_content'] = str_replace("&nbsp;"," ",$list[$i]['wr_content']);
			?>
			<li style="padding:0px;margin:0px;width: 100% !important;">
				<div class="post-image">
					<a href="<?php echo $wr_href; ?>"<?php echo $wr_target;?>>
						<div class="img-wrap">
							<div class="img-item img-full">
								<?php echo run_replace('thumb_image_tag', $img_content, $thumb); ?>
							</div>
						</div>
					</a>
				</div>
				<div>
					<div class="post-subject">
						<a href="<?php echo $wr_href; ?>"<?php echo $wr_target;?>>
						<strong><?php echo $list[$i]['subject'];?></strong>
						<div class="post-text">
							<?php echo get_text(cut_str(strip_tags($list[$i]['wr_content']),300));?>
						</div>
						</a>
					</div>
					<!--p><span>Hidden title</span><em>Show title</em></p-->
					<div class="lt_info">
						<span class="lt_nick"><?php echo $list[$i]['name'] ?></span>
						<?php if($list[$i]['ca_name']) { ?>
						<span class="lt_cate"><?php echo $list[$i]['ca_name'];?></span>
						<?php } ?>
						<span class="lt_date"><?php echo $list[$i]['datetime2'] ?></span>
					</div>
				</div>
			</li>
			<?php }  ?>
			<?php if ($list_count == 0) { //게시물이 없을 때  ?>
			<li>게시물이 없습니다.</li>
			<?php }  ?>
		</ul>
	</div>
</div>

<script type="text/javascript">
	$(document).ready(function(){
		/* 슬라이더 - 3칼럼노출 */
		var slider_column = $('.slider_column').owlCarousel({
		items:<?php echo $items;?>,
		loop:true,
		mouseDrag:false,
		nav:true,
		autoplay:true,
		autoplayTimeout:4000000,
		autoplayHoverPause:true,
		center: false,
		margin: <?php echo $margin;?>
		});

	});
</script>
