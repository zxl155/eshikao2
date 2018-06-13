! function($) {
    function JSlide(ele, opt) {

        this.$ele = $(ele);
        opt = $.extend({}, this.defaultOption, opt);
        this.dataArr = opt.dataArr;
        this.num = this.dataArr.length;
        this.currIndex = opt.index ? opt.index : 0;
        this.$preload = this.$ele.find('.jslide_preload');
        this.$numText = this.$ele.parent().find('.numtotal');
        this.$author = this.$ele.parent().find('.author');
        this.holderW = this.$ele.width(),
        this.holderH = this.$ele.height();


        this.imgLoad();

        var self = this;
        this.$ele.find('.jslide_prev').click(function(e){
        	e.preventDefault();
        	self.prev();
        });
        this.$ele.find('.jslide_next').click(function(e){
        	e.preventDefault();
        	self.next();
        });
        /*self.$ele.click(function(e) {
            if (e.offsetX > self.holderW / 2) {
                self.next();
            } else {
                self.prev();
            }

        });*/
        $(document.body).click(function(e){
            if (!$(e.target).closest("#jSlideModal, #xlznPhotoHolder").length && $('#jSlideModal').is(":visible")) {
                $('#jSlideModal, .xlzn_modal_cover_heavy').hide();
            }
        });
        
    }
    JSlide.prototype = {
        imgLoad: function(src) {
            var self = this;

            self.$preload.show();
            self.$numText.text(parseInt(self.currIndex)+1+'/'+self.dataArr.length);
            self.$author.text(self.dataArr[self.currIndex].username);
            self.$author.attr('href', '/user/'+ self.dataArr[self.currIndex].userid);
            if (!src) {
                //src = self.imgData[self.currIndex];
                src = self.dataArr[self.currIndex].path.replace('_m.', '_b.');
            }
            if (self.$ele.find('[data-idx="' + self.currIndex + '"]').length > 0) {
                self.$preload.hide();
                self.$currImg = self.$ele.find('[data-idx="' + self.currIndex + '"]').fadeIn(500);
            } else {
                if (!self.loading) {
                    self.loading = true;
                    $('<img/>').attr('src', src).on('load error', function(e) {
                        if(e.type == 'error'){
                            self.loading = false;
                            return;
                        }
                        var imgW = this.width,
                            imgH = this.height;

                        if (imgW > self.holderW) {
                            imgH = parseInt(imgH * self.holderW / imgW);
                            imgW = self.holderW;
                        }

                        if (imgH > self.holderH) {
                            imgW = parseInt(imgW * self.holderH / imgH);
                            imgH = self.holderH;
                        }
                        self.$preload.hide();
                        $(this).css({
                            width: imgW,
                            height: imgH,
                            marginTop: -1 * imgH / 2,
                            marginLeft: -1 * imgW / 2
                        }).addClass('jslide_img').appendTo(self.$ele).fadeIn(500);
                        self.loading = false;
                        self.$currImg = $(this).attr('data-idx', self.currIndex);
                    }).each(function() {
                        if(this.complete) $(this).load();
                    });
                }
            }
        },
        next: function() {
            var self = this;
            if (self.currIndex == self.dataArr.length - 1) {
                self.currIndex = 0;
            } else {
                self.currIndex++;
            }
            if (!!self.$currImg) {
                self.$currImg.fadeOut(500, function() {
                    $(this).hide();
                });
            }

            self.imgLoad();
        },
        prev: function() {
            var self = this;
            if (self.currIndex == 0) {
                self.currIndex = self.dataArr.length - 1;
            } else {
                self.currIndex--;
            }
            if (!!self.$currImg) {
                self.$currImg.fadeOut(500, function() {
                    $(this).hide();
                });
            }
            self.imgLoad();
        },
        to: function(index) {
            var self = this;
            //self.$currImg.remove();
            self.$ele.find('[data-idx]').remove();
            //var imgSrc = self.imgData[index];
            self.currIndex = index;
            var imgSrc = self.dataArr[self.currIndex].path.replace('_m.', '_b.');
            self.imgLoad(imgSrc);
        }
    }
    JSlide.defaultOption = {
        index: 0
    }
    $.fn.jSlide = function(option) {
        return this.each(function() {
            var $this = $(this),
                data = $this.data('jSlide');

            if (data) {
                data.to(option.index);
            }
            if (!data) $this.data('jSlide', (data = new JSlide(this, option)));
            
        });
    }
}(jQuery);