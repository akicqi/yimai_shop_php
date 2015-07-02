(function($){
    $.fn.extend({
        'imgSlideShow': function(options){
            // 扩展参数
            var op = $.extend({
                'itemclass': null,
                'desclass': null,
                'delay': 5000
            }, options);
            // 设置窗口的样式
            this.css({
                position: 'relative',
                overflow: 'hidden'
            });
            // 设置图片项的样式
            this.children('.' + op.itemclass).css({
                clear: 'both',
                display: 'none'
            });
            // 添加数字标签项窗口
            $('<div id="imgslideshow_label0000"></div>').appendTo(this).css({
                position: 'absolute',
                bottom: '2px',
                right: '2px',
                width: '100%',
                height: '22px',
                'z-index': 100,
                overflow: 'hidden'
            });
            // 取得所有图片项
            var items = $('.' + op.itemclass, this);
            // 图片项的数目
            var itemsLength = items.length;
            // 当前的图片项索引
            var curItemIndex = 0;
            // 当前的 timeout 函数返回值
            var timeoutReturn;
            
            // 添加数字标签项
            for(var i=itemsLength-1;i>=0;i--){
                $('<div class="label0000" id="label0000' + i + '">' + (i + 1) + '</div>').appendTo('#imgslideshow_label0000').css({
                    float: 'right',
                    width: '20px',
                    height: '20px',
                    'line-height': '20px',
                    'text-align': 'center',
                    'font-weight': 'bold',
                    'background-color': '#E98315',
                    'opacity': 0.8,
                    'border': '1px solid #000',
                    'cursor': 'pointer',
                    'margin-left': '2px'
                    // 标签项的单击事件
                }).mouseover(function(e){
                    // 停止当前的图片项动画并将其隐藏和设置回透明度为1
                    items.eq(curItemIndex).stop().hide().css({
                        opacity: 1
                    });
                    // 阻止事件流
                    e.stopPropagation();
                    // 暂停当前的 timeout 函数
                    clearTimeout(timeoutReturn);
                    // 设置标签项的样式
                    $('#label0000' + curItemIndex).css('background-color', '#EFEBD6');
                    items.eq(curItemIndex).hide();
                    $('#label0000' + curItemIndex).css('background-color', '#EFEBD6');
                    // 从当前的索引开始，重新开始图片动画
                    curItemIndex = parseInt($(this).text()) - 1;
                    imgSlideShowProcess();
                });
            }
            // 图片动画执行函数
            var imgSlideShowProcess = function(){
                $('#label0000' + curItemIndex).css('background-color', '#FF8210');
                items.eq(curItemIndex).fadeIn(300, function(){
                    timeoutReturn = setTimeout(imgFadeOut, op.delay);
                });
            };
            // 淡出图片
            var imgFadeOut = function(){
                items.eq(curItemIndex).fadeOut(1, function(){
                    $('#label0000' + curItemIndex).css('background-color', '#EFEBD6');
                    curItemIndex = (curItemIndex + 1) % itemsLength;
                    imgSlideShowProcess();
                });
            };
            // 开始图片动画
            imgSlideShowProcess();

            return this;
        }
    });
})(jQuery);