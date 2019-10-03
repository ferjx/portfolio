galleryIntervalTime=2000;//Время смены картинок
smoothChangeTime=20;//Время смены текущей картинки на следующую
//===================================


allLI=document.getElementsByTagName("li");
smallImgLI=[];
bigImgLI=[];
prevActiveElement=0;
nextActiveElement=0;

for(var i=0; i<allLI.length; i++){
	if(allLI[i].className=="smallImg active" || allLI[i].className=="smallImg"){
		smallImgLI.push(allLI[i]);
		allLI[i].onclick=function(){changeLIClass(this);}
		}
	if(allLI[i].className=="bigImg active" || allLI[i].className=="bigImg")bigImgLI.push(allLI[i]);
	}
function changeLIClass(currentElement){
	if(!smoothChanged)return[];
	if(currentElement!=null){
		
		for(var i=0; i<bigImgLI.length; i++){
			if(currentElement==smallImgLI[i]){nextActiveElement=i;break;}
			}
		
		}else{
		
		nextActiveElement++;
		if(nextActiveElement >= bigImgLI.length)nextActiveElement=0;
		
		}
	
	smallImgLI[prevActiveElement].className="smallImg";
	
	bigImgLI[nextActiveElement].className="bigImg active";
	smallImgLI[nextActiveElement].className="smallImg active";
	
	smoothChangeImage('set');
	
	galleryIntervalManager(0, true);
	galleryIntervalManager(galleryLastStatus);
	}

galleryLastStatus=0;
function galleryIntervalManager(act, nosave){
	if(act==1){
		galleryInterval=setInterval('changeLIClass()', galleryIntervalTime);//Интервал смены картинки
		}else{
		clearInterval(galleryInterval);
		}
	if(nosave==null)galleryLastStatus=act;
	}
galleryIntervalManager(1);

smoothChanged=true;
smoothChangedPercent=parseInt("100");
smoothChangeInterval=null;
function smoothChangeImage(act){
	switch(act){
		case "set":
		if(!smoothChanged)return[];
		smoothChanged=false;
		smoothChangedPercent=0;
		
		if(document.all){
			bigImgLI[nextActiveElement].style.filter='alpha(opacity=0)';
			}else{
			bigImgLI[nextActiveElement].style.opacity=0;
			}
		
		smoothChangeInterval=setInterval('smoothChangeImage("render")', smoothChangeTime);
		break;
		
		case "render":
		
		smoothChangedPercent+=5;
		if(smoothChangedPercent > 100)smoothChangedPercent=100;
		
		if(document.all){
			bigImgLI[prevActiveElement].style.filter='alpha(opacity='+(100 - smoothChangedPercent)+')';
			bigImgLI[nextActiveElement].style.filter='alpha(opacity='+(smoothChangedPercent)+')';
			}else{
			bigImgLI[prevActiveElement].style.opacity=(100 - smoothChangedPercent) / 100;
			bigImgLI[nextActiveElement].style.opacity=(smoothChangedPercent) / 100;
			}
		
		if(smoothChangedPercent == 100){
			smoothChanged=true;
			clearInterval(smoothChangeInterval);
			bigImgLI[prevActiveElement].className="bigImg";
			prevActiveElement=nextActiveElement;
			}
		break;
		}
	}

function galleryManager(o){
	if(o.className=='pause'){
		galleryIntervalManager(0);
		o.className='play';
		}else{
		galleryIntervalManager(1);
		o.className='pause';
		}
	}