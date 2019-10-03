'use strict';

function ImageList(options) {
    this.options = options;

    this.items = [];
    this.itemindex = -1;
    this.$container = this.options.$container;
    this.$uploader = this.options.$uploader;

    var i, item, that;
    that = this;

    for (i in this.options.images) {
        if (this.options.images.hasOwnProperty(i)) {
            item = new ImageItem();
            item.setImage(this.options.images[i]);
            item.setHiddenInput(i,this.options.images[i]);
            item.setHiddenInputMd5(i,this.options.images_md5[i]);
            this.addItem(item);
        }
    }

    this.$uploader = this.$uploader.fileupload({
        dataType: 'json',
        url: this.options.uploadUrl,
        add: function (e, data) {
            if (e.isDefaultPrevented()) {
                return false;
            }
            data.process().done(function () {
                data.context.xhr = data.submit();
            });
            return true;
        }
    });

    this.$uploader.on('fileuploadadd', function(e, data) {
        var item;
        if (!that.checkState()) {
            return false;
        }
        item = new ImageItem();
        that.addItem(item);
        data.context = item;
    });
    this.$uploader.on('fileuploadprogress', function(e, data) {
        var item;
        item = data.context;
        item.setProgress(data.loaded / data.total);
    });
    this.$uploader.on('fileuploaddone', function(e, data) {
        var item, result;
        item = data.context;
        result = data.result;
        if (result.status == 1) {
            item.setImage(result.data['preview_url']);
            item.setHiddenInput(item.index, result.data['preview_url']);
            item.setHiddenInputMd5(item.index, result.data['md5_file']);
        }
    });

}

ImageList.prototype.getItemIndex = function(item) {
    var i;
    for (i in this.items) {
        if (this.items.hasOwnProperty(i) && this.items[i] === item) {
            return i;
        }
    }
    return null;
};

ImageList.prototype.checkState = function() {
    var remaining = this.options.maxNum - this.items.length;
    if (this.options.$remaining) {
        this.options.$remaining.text(remaining);
    }
    if (remaining > 0) {
        $(this.$uploader.selector).removeAttr('disabled');
        return true;
    }
    else {
        $(this.$uploader.selector).attr('disabled', true);
        return false;
    }
};

ImageList.prototype.addItem = function(item) {
    var that = this;
    this.items.push(item);
    item.index = this.itemindex = this.itemindex + 1;
    this.$container.append(item.$obj);
    item.onCancel = function () {
        $.post(that.options.deleteUrl, { image: item.url }).success(function () {
            that.removeItem(item);
        });
    };
    item.onRotate = function () {
        $.post(that.options.rotateUrl, { image: item.url }, function ( data ) {
            if (data.img_small != '') {
                item.$image.attr('src', data.img_small);
            }
            else if (data.img_big != '') {
                item.$image.attr('src', data.img_big);
            }
            item.url = item.$image.attr('src');
            item.$hiddeninput.val(item.$image.attr('src'));
        }, "json");
    };
    this.checkState();
    return this;
};

ImageList.prototype.removeItem = function(item) {
    var index;
    index = this.getItemIndex(item);
    if (index !== null) {
        this.items.splice(index, 1);
        item.$obj.detach();
    }
    this.checkState();
    return this;
};

function ImageItem() {
    var that = this;
    this.url = null;
    this.index = 0;
    this.$obj = $('<div>').addClass('item');
    this.$preview = $('<div>').addClass('preview').appendTo(this.$obj);
    this.$remove = $('<span>Удалить</span>').addClass('remove').appendTo(this.$obj);
    this.$hiddeninput = $('<input type="hidden">').appendTo(this.$obj);
    this.$hiddeninputMd5 = $('<input type="hidden">').appendTo(this.$obj);
    this.$imagerotate = $('<span>').addClass('img_upload_rotate');
    this.$progress_value = $('<small>');
    this.$progress = $('<div>').addClass('progress').append(this.$progress_value);
    this.$image = $('<img>');

    this.xhr = null;
    this.onCancel = null;

    this.$remove.on('click', function() {
        if (that.xhr) {
            that.xhr.abort();
        }
        if (typeof that.onCancel == 'function') {
            that.onCancel();
        }
    });

    this.$imagerotate.on('click', function() {
        if (typeof that.onRotate == 'function') {
            that.onRotate();
        }
    });
}

ImageItem.prototype.setProgress = function(value) {
    this.$preview.html(this.$progress);
    this.$progress_value.width(value * 100 + '%');
    this.$remove.text('Отменить');
};

ImageItem.prototype.setImage = function(src) {
    this.url = src;
    this.$preview.html(this.$image);
    this.$image.attr('src', src);
    this.$remove.text('Удалить');
    this.$imagerotate.appendTo(this.$preview);
};

ImageItem.prototype.setHiddenInput = function(index, src) {
    this.$hiddeninput.attr('name', 'imageupload['+index+'][url]');
    this.$hiddeninput.val(src);
};

ImageItem.prototype.setHiddenInputMd5 = function(index, src) {
    this.$hiddeninputMd5.attr('name', 'imageupload['+index+'][md5]');
    this.$hiddeninputMd5.val(src);
};
