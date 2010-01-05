<script language="JavaScript" type="text/JavaScript">
// Code written and copyright by www.tweaktown.com. You will have to check with them whether you can use it...
setTimeout('detect_abp()', 10000);
var isFF = (navigator.userAgent.indexOf("Firefox") > -1) ? true : false;
var hasABP = false;

function detect_abp()
{
 if( isFF )
 {
  if( Components.interfaces.nsIAdblockPlus != undefined )
  {
   hasABP = true;
  }
  else
  {
   var AbpImage = document.createElement("IMG");
   AbpImage.id = 'abp_detector';
   AbpImage.src = '/textlink-ads.jpg';
   AbpImage.style.width = '0px';
   AbpImage.style.height = '0px';
   AbpImage.style.top = '-1000px';
   AbpImage.style.left = '-1000px';
   document.body.appendChild(AbpImage);
   hasABP = (document.getElementById('abp_detector').style.display == 'none');

   var e = document.getElementsByTagName("iframe");
   for (var i = 0; i < e.length; i++)
   {
    if(e[i].clientHeight == 0)
    {
     hasABP = true;
    }
   }
  }

  if(hasABP == true)
  {
   history.go(1);
   // Go to somewhere useful, a good example is at http://www.tweaktown.com/supportus.html
   window.location( "http://www.tweaktown.com/supportus.html" );
  }
 }
}
</script>