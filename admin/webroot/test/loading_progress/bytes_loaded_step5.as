﻿/*** bytes_loaded.fla   frame 1, Actions layer ***/// variable declarationsvar loaded:Number;var total:Number;var percent:Number;// function declarations// event callback handlersthis.onEnterFrame = function () {    loaded = _level1.getBytesLoaded();    total  = _level1.getBytesTotal();    if (loaded == undefined || total == undefined || total < 10) {        return;    }    bytesLoaded_txt.text = loaded;    bytesTotal_txt.text  = total;    // trace(loaded + "/" + total + " loop # " + percent++);    if (loaded == total) {        this.onEnterFrame = undefined;    }}// initial frame actionsloadMovieNum("large.swf", 1);this.swapDepths(2);               // swap text fields with contents of Level 2/*loaded = _level1.getBytesLoaded();total  = _level1.getBytesTotal();bytesLoaded_txt.text = loaded;bytesTotal_txt.text  = total;*/