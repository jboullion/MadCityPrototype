function jbSetCookie(e,t,n){var o=new Date;o.setTime(o.getTime()+24*n*60*60*1e3);var a="expires="+o.toUTCString();document.cookie=e+"="+t+";"+a+";path=/"}function jbGetCookie(e){for(var t=e+"=",n=document.cookie.split(";"),o=0;o<n.length;o++){for(var a=n[o];" "==a.charAt(0);)a=a.substring(1);if(0==a.indexOf(t))return a.substring(t.length,a.length)}return""}function jbDeleteCookie(e){setCookie(e,"",-1)}function JBTemplateEngine(e,t){for(var n,o=/<%([^%>]+)?%>/g;n=o.exec(e);)e=e.replace(n[0],t[n[1]]);return e}String.prototype.jbCleanNumber=function(){var e=this.replace(/[^0-9.-]/g,"");return(isNaN(e)||""==e)&&(e=0),e},Number.prototype.jbFormatMoney=function(e,t,n){var o=this,e=isNaN(e=Math.abs(e))?2:e,t=void 0==t?".":t,n=void 0==n?",":n,a=o<0?"-":"",i=parseInt(o=Math.abs(+o||0).toFixed(e))+"",r=(r=i.length)>3?r%3:0;return a+(r?i.substr(0,r)+n:"")+i.substr(r).replace(/(\d{3})(?=\d)/g,"$1"+n)+(e?t+Math.abs(o-i).toFixed(e).slice(2):"")},String.prototype.replaceAll=function(e,t){return this.replace(new RegExp(e,"g"),t)},Number.prototype.random=function(){var e=1,t=Math.floor(this);return Math.floor(Math.random()*(t-e+1))+e},Number.prototype.round=function(e){var t=Math.pow(10,e||0);return Math.round(this*t)/t},window.scrollTo(0,1);var BASE_DIR="/madcity/";jQuery(document).ready(function(e){$menu=e("#menu"),$shade=e("#menu-shade"),$toggle=e(".menu-toggle"),$numberInputs=e(".number-control"),$actionModals=e(".action-modal"),$actionContent=e(".action-content"),$actionClose=e(".action-close"),$toggle.click(function(e){$menu.toggleClass("open"),$shade.toggleClass("open")}),$shade.click(function(e){$menu.removeClass("open"),$shade.removeClass("open")}),$numberInputs.on("input",function(){return this.value.length>this.maxLength&&(this.value=this.value.slice(0,this.maxLength))}),$actionContent.click(function(e){e.stopPropagation()}),$actionClose.click(function(e){$actionModals.removeClass("open")}),$actionModals.click(function(t){e(this).removeClass("open")})}),jQuery(document).ready(function(e){$characterSheet=e("#character-sheet"),$inputSaves=e(".character-save"),$rollers=e(".roller"),$rollerModal=e("#roller-modal"),$mutate=e(".mutate"),$mutateModal=e("#mutate-modal"),$info=e(".info"),$infoModal=e("#info-modal"),$addPower=e("#add-power"),$powerModal=e("#power-modal"),$addEquipment=e("#add-equipment"),$equipmentModal=e("#equipment-modal"),$increment=e(".increment"),$decrement=e(".decrement"),$actionDice=e(".action-dice"),$actionDiceResult=e("#dice-result"),$rollers.click(function(e){$rollerModal.addClass("open")}),$mutate.click(function(e){$mutateModal.addClass("open")}),$info.click(function(e){$infoModal.addClass("open")}),$addPower.click(function(e){$powerModal.addClass("open")}),$addEquipment.click(function(e){$equipmentModal.addClass("open")}),$increment.click(function(t){var n=e(this).data("target"),o=parseInt(e("#"+n).val().jbCleanNumber())+1;o<0&&(o=0),e("#"+n).val(o).trigger("change")}),$decrement.click(function(t){var n=e(this).data("target"),o=parseInt(e("#"+n).val().jbCleanNumber())-1;o<0&&(o=0),e("#"+n).val(o).trigger("change")});var t=null;$actionDice.click(function(n){n.preventDefault(),n.stopPropagation(),rolling=!0,t&&clearTimeout(t);var o=parseInt(e(this).data("value"));$actionDiceResult.css("left",e(this).position().left).addClass("open").find("span").html(o.random()),t=setTimeout(function(){$actionDiceResult.removeClass("open")},2e3)}),$characterSheet.submit(function(t){t.preventDefault();var n=e(this).serializeArray();e.post(BASE_DIR+"rest/character/update",n,function(e){},"json")}),$inputSaves.change(function(e){$characterSheet.trigger("submit")})});