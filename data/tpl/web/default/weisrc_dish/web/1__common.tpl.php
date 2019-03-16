<?php defined('IN_IA') or exit('Access Denied');?><audio id="music" >
    <source src="http://fanyi.sogou.com/reventondc/microsoftGetSpeakFile?from=translateweb&spokenDialect=zh-CHS&text=您有未处理的订单，请尽快处理" type="audio/mpeg">
    <embed height="0" width="0" src="http://fanyi.sogou.com/reventondc/microsoftGetSpeakFile?from=translateweb&spokenDialect=zh-CHS&text=您有未处理的订单，请尽快处理">


</audio>
<script>
    var audioEl = $("#music")[0];
    (function() {
        function checkorder() {
            $.post("<?php  echo $this->createWebUrl('checkorder', array('storeid' => $storeid));?>", function(data){
                if(data == 'success') {
                    var tip = '您有未处理的订单，请尽快处理';
                    audioEl.src="http://fanyi.sogou.com/reventondc/microsoftGetSpeakFile?from=translateweb&spokenDialect=zh-CHS&text=" + tip;
                    audioEl.load();
                    audioEl.play();
                } else {
                    if (data != '') {
                        audioEl.src="http://fanyi.sogou.com/reventondc/microsoftGetSpeakFile?from=translateweb&spokenDialect=zh-CHS&text=" + data;
                        audioEl.load();
                        audioEl.play();
                    }
                }
                setTimeout(checkorder, 10000);
            });
        }

        function log(info) {
            console.log(info);
            // alert(info);
        }
        function forceSafariPlayAudio() {
            audioEl.load(); // iOS 9   还需要额外的 load 一下, 否则直接 play 无效
            audioEl.play(); // iOS 7/8 仅需要 play 一下
        }

        // 可以自动播放时正确的事件顺序是
        // loadstart
        // loadedmetadata
        // loadeddata
        // canplay
        // play
        // playing
        //
        // 不能自动播放时触发的事件是
        // iPhone5  iOS 7.0.6 loadstart
        // iPhone6s iOS 9.1   loadstart -> loadedmetadata -> loadeddata -> canplay
        audioEl.addEventListener('loadstart', function() {
            log('loadstart');
        }, false);
        audioEl.addEventListener('loadeddata', function() {
            log('loadeddata');
        }, false);
        audioEl.addEventListener('loadedmetadata', function() {
            log('loadedmetadata');
        }, false);
        audioEl.addEventListener('canplay', function() {
            log('canplay');
        }, false);
        audioEl.addEventListener('play', function() {
            log('play');
            // 当 audio 能够播放后, 移除这个事件
            window.removeEventListener('touchstart', checkorder, false);
        }, false);
        audioEl.addEventListener('playing', function() {
            log('playing');
        }, false);
        audioEl.addEventListener('pause', function() {
            log('pause');
        }, false);

        // 由于 iOS Safari 限制不允许 audio autoplay, 必须用户主动交互(例如 click)后才能播放 audio,
        // 因此我们通过一个用户交互事件来主动 play 一下 audio.
        window.addEventListener('touchstart', checkorder, false);
        checkorder();
    })();

</script>

