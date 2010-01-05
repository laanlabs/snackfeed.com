package {
    import flash.display.Loader ;
    import flash.display.MovieClip;
    import flash.display.Sprite;
    import flash.events.Event;
    import flash.net.URLRequest;

    public class FlashPanoramaSprite extends Sprite
    {
        private var panorama:MovieClip;
        private var loader:Loader = new Loader();

        public function FlashPanoramaSprite()
        {
            
            Security.allowDomain("*");
            loader.load(new URLRequest("http://www.hulu.com/playerembed.swf?eid=R8I5wytNPeKwj-BEwNYX6g"));
            addChild(loader);
           
            loader.contentLoaderInfo.addEventListener(Event.COMPLETE, loadComplete);
        }
       
        private function loadComplete (e:Event) : void
        {
            panorama = loader.content as MovieClip;
            panorama.setArea(100,50,400,300);
           
            panorama.loadPanorama("panoName=images/snow");
        }
    }
} 