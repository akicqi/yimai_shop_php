<?php

	//分页工具类

	class Page{

		//分页类：就是产生一个能够点击的链接字符串
		/*
		 * 获取分页字符串
		 * @param1 string $script，要请求的脚本
		 * @param2 string $act，要请求的动作
		 * @param3 int $counts，总数据量
		 * @param4 int $pagecount，每页显示的数据量
		 * @param5 int $page = 1，当前的页码
		*/
		public static function getPageString($script,$act,$counts,$pagecount,$page = 1){
			//1.做一个统计字符串
			$pages = ceil($counts / $pagecount);
			$display = "<span id='display'>当前总共有{$counts}条记录，总共{$pages}页，当前是第{$page}页，每页显示{$pagecount}条记录</span>";

			//2.点击分页功能
			//求页码
			$prev = $page > 1 ? $page - 1 : 1; 
			$next = $page <$pages ? $page + 1 : $pages; 
			$click = <<<END
			<span id="click">&nbsp;
			<a href="{$script}?act={$act}&page=1">首页</a>&nbsp;
			<a href="{$script}?act={$act}&page={$prev}">上一页</a>&nbsp;
			<a href="{$script}?act={$act}&page={$next}">下一页</a>&nbsp;
			<a href="{$script}?act={$act}&page={$pages}">末页</a>&nbsp;
			</span>
END;

			/*//3.列表分页功能
			$list = '<span id="list">';
			for($i = 1;$i <= $pages;$i++){
				$list .= "&nbsp;<a href='{$script}?act={$act}&page={$i}'>$i</a>&nbsp;";
			}
			$list .= '</span>';

			//4.下拉框分页
			$select = "&nbsp;&nbsp;<span id='select'><select onchange=\"location.href='{$script}?act={$act}&page='+this.value;\">";
			for($i = 1;$i <= $pages;$i++){
				//判断
				if($i == $page){
					$select .= "<option value='{$i}' selected=\"selected\">{$i}</option>";
				}else{
					$select .= "<option value='{$i}'>{$i}</option>";
				}
			}
			$select .= '</select></span>';

			//5.输入确定分页
			$form = <<<END
			<form action="{$script}" method="get" id='form' style="display:inline">
				<input type="hidden" name="act" value="{$act}"/>
				<input type="text" name="page" value="{$page}" onfocus="this.value=''"/>
				<input type="submit" value="确定"/>
			</form>
END;


			return $display . $click . $list . $select . $form;*/
			return $display . $click;
		}
	}