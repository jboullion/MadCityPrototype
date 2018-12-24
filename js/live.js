function jbSetCookie(e,t,r){var o=new Date;o.setTime(o.getTime()+24*r*60*60*1e3);var i="expires="+o.toUTCString();document.cookie=e+"="+t+";"+i+";path=/"}function jbGetCookie(e){for(var t=e+"=",r=document.cookie.split(";"),o=0;o<r.length;o++){for(var i=r[o];" "==i.charAt(0);)i=i.substring(1);if(0==i.indexOf(t))return i.substring(t.length,i.length)}return""}function jbDeleteCookie(e){jbSetCookie(e,"",-1)}function JBTemplateEngine(e,t){for(var r in t){var o=new RegExp("<%"+r+"%>","gi");e=e.replace(o,t[r])}return e}function googleSignIn(e){var t=e.getBasicProfile(),r=e.getAuthResponse().id_token,o={email:t.getEmail(),id_token:r};jbSetCookie("google-idtoken",r,1),jbSetCookie("email",t.getEmail(),1),jbUserFormSend("google-signin",o,$signinForm)}function jbSignOut(e,t){e.preventDefault();var r=gapi.auth2.getAuthInstance();r.isSignedIn.get()?(console.log("Google Logout"),r.signOut().then(function(){jbDeleteCookie("google-idtoken"),jbDeleteCookie("email"),$.post(BASE_DIR+"rest/user/logout",{email:t},function(e){e.success?window.location.href=window.location.protocol+"//"+window.location.hostname:console.log(e)})})):t&&(console.log("Mad City Logout"),$.post(BASE_DIR+"rest/user/logout",{email:t},function(e){jbDeleteCookie("email"),e.success?window.location.href=window.location.protocol+"//"+window.location.hostname:console.log(e)}))}function onLoad(){gapi.load("auth2",function(){gapi.auth2.init()})}function jbUserFormSend(e,t,r){$.post(BASE_DIR+"rest/user/"+e,t,function(e){e.success?"forgot-form"==r[0].id?(r.find(".alert-danger").addClass("hidden"),r.find(".alert-success").html(e.success).removeClass("hidden")):(jbSetCookie("email",t.email,1),window.location.href=window.location.protocol+"//"+window.location.hostname+"/character/"):e.error?r.find(".alert-danger").html(e.error).removeClass("hidden"):r.find(".alert-danger").html("Unknown Error").removeClass("hidden"),"forgot-form"==r[0].id&&r.find(".btn-primary").html("Get New Password").prop("disabled",!1)},"json")}String.prototype.jbCleanNumber=function(){var e=this.replace(/[^0-9.-]/g,"");return(isNaN(e)||""==e)&&(e=0),e},String.prototype.capitalize=function(){return this.charAt(0).toUpperCase()+this.slice(1)},Number.prototype.jbFormatMoney=function(e,t,r){var o=this,e=isNaN(e=Math.abs(e))?2:e,t=void 0==t?".":t,r=void 0==r?",":r,i=o<0?"-":"",n=parseInt(o=Math.abs(+o||0).toFixed(e))+"",a=(a=n.length)>3?a%3:0;return i+(a?n.substr(0,a)+r:"")+n.substr(a).replace(/(\d{3})(?=\d)/g,"$1"+r)+(e?t+Math.abs(o-n).toFixed(e).slice(2):"")},String.prototype.replaceAll=function(e,t){return this.replace(new RegExp(e,"g"),t)},Number.prototype.random=function(){var e=1,t=Math.floor(this);return Math.floor(Math.random()*(t-e+1))+e},Number.prototype.round=function(e){var t=Math.pow(10,e||0);return Math.round(this*t)/t},$.fn.serializeObject=function(){var e={},t=this.serializeArray();return $.each(t,function(){void 0!==e[this.name]?(e[this.name].push||(e[this.name]=[e[this.name]]),e[this.name].push(this.value||"")):e[this.name]=this.value||""}),e},window.scrollTo(0,1);var BASE_DIR="/";jQuery(document).ready(function(e){$menu=e("#menu"),$shade=e("#menu-shade"),$toggle=e(".menu-toggle"),$numberInputs=e(".number-control"),$actionModals=e(".action-modal"),$actionContent=e(".action-content"),$actionClose=e(".action-close"),$toggle.click(function(e){$menu.toggleClass("open"),$shade.toggleClass("open")}),$shade.click(function(e){$menu.removeClass("open"),$shade.removeClass("open")}),$numberInputs.on("input",function(){return this.value.length>this.maxLength&&(this.value=this.value.slice(0,this.maxLength))}),$actionContent.click(function(e){e.stopPropagation()}),$actionClose.click(function(e){$actionModals.removeClass("open")}),$actionModals.click(function(t){e(this).removeClass("open")})}),jQuery(document).ready(function(e){$body=e("body"),$characterSheet=e("#character-sheet"),$inputSaves=e(".character-save"),$rollers=e(".roller"),$rollerModal=e("#roller-modal"),$mutate=e(".mutate"),$mutateModal=e("#mutate-modal"),$addPower=e("#add-power"),$powerModal=e("#power-modal"),$powerForm=e("#power-form"),$powerTable=e("#power-table tbody"),$editPowerModal=e("#edit-power-modal"),$editPowerForm=e("#edit-power-form"),$editPowerKey=e("#edit-power-key"),$deletePower=e("#delete-power"),powerTemplate=e("#power-template").html(),$addEquipment=e("#add-equipment"),$equipmentModal=e("#equipment-modal"),$equipmentForm=e("#equipment-form"),$equipmentTable=e("#equipment-table tbody"),$editEquipmentModal=e("#edit-equipment-modal"),$editEquipmentForm=e("#edit-equipment-form"),$editEquipmentKey=e("#edit-equipment-key"),$deleteEquipment=e("#delete-equipment"),equipmentTemplate=e("#equipment-template").html(),$increment=e(".increment"),$decrement=e(".decrement"),$actionDice=e(".action-dice"),$actionDiceResult=e("#dice-result"),$rollers.click(function(e){$rollerModal.addClass("open")}),$mutate.click(function(e){$mutateModal.addClass("open")}),$addPower.click(function(e){$powerModal.addClass("open")}),$body.on("click",".edit-power",function(t){var r=e(this).data("object"),o=e(this).data("key");if(r.level)var i=r.level;else var i=1;e("#edit-power-level").val(i),e("#edit-power-type").val(r.type),e("#edit-power-name").val(r.name),e("#edit-power-damage").val(r.damage),e("#edit-power-effect").val(r.effect),e("#edit-power-desc").val(r.desc),$editPowerKey.val(o),$editPowerModal.addClass("open")}),$body.on("click",".edit-equipment",function(t){var r=e(this).data("object"),o=e(this).data("key");e("#edit-equipment-slot").val(r.slot),e("#edit-equipment-name").val(r.name),e("#edit-equipment-bonus").val(r.bonus),e("#edit-equipment-stat").val(r.stat),e("#edit-equipment-desc").val(r.desc),$editEquipmentKey.val(o),$editEquipmentModal.addClass("open")}),$addEquipment.click(function(e){$equipmentModal.addClass("open")}),$increment.click(function(t){var r=e(this).data("target"),o=parseInt(e("#"+r).val().jbCleanNumber())+1;o<0&&(o=0),e("#"+r).val(o).trigger("change")}),$decrement.click(function(t){var r=e(this).data("target"),o=parseInt(e("#"+r).val().jbCleanNumber())-1;o<0&&(o=0),e("#"+r).val(o).trigger("change")});var t=null;$actionDice.click(function(r){r.preventDefault(),r.stopPropagation(),rolling=!0,t&&clearTimeout(t);var o=parseInt(e(this).data("value"));$actionDiceResult.css("left",e(this).position().left).addClass("open").find("span").html(o.random()),t=setTimeout(function(){$actionDiceResult.removeClass("open")},2e3)}),$characterSheet.submit(function(t){t.preventDefault();var r=e(this).serializeArray();e.post(BASE_DIR+"rest/character/update",r,function(e){},"json")}),$inputSaves.change(function(e){$characterSheet.trigger("submit")}),$powerForm.submit(function(t){t.preventDefault();var r=e(this).find("button"),o=e(this).serializeArray(),i=e(this).serializeObject();r.prop("disabled",!0),e.post(BASE_DIR+"rest/character/powers/add",o,function(e){if(null!=e.success){$powerForm.trigger("reset"),$powerForm.find(".action-close").first().trigger("click");var t=JBTemplateEngine(powerTemplate,{key:$powerTable.find("tr").length,object:JSON.stringify(i),type:i.type,name:i.name,damage:i.damage,effect:i.effect});$powerTable.append(t)}else null!=e.error&&alert("Error: "+e.error);r.prop("disabled",!1)},"json")}),$editPowerForm.submit(function(t){t.preventDefault();var r=e(this).find("button"),o=e(this).serializeArray(),i=e(this).serializeObject(),n=$editPowerKey.val();r.prop("disabled",!0),e.post(BASE_DIR+"rest/character/powers/edit",o,function(t){if(null!=t.success){$editPowerForm.trigger("reset"),$editPowerForm.find(".action-close").first().trigger("click");var o=e("#power-"+n);o.data("object",i),o.find(".type span").html(i.type),o.find(".name").html(i.name),o.find(".damage").html(i.damage),o.find(".effect").html(i.effect)}else null!=t.error&&alert("Error: "+t.error);r.prop("disabled",!1)},"json")}),$deletePower.click(function(t){t.preventDefault();var r=$editPowerKey.val(),o=$editPowerForm.serializeObject(),i=$editPowerForm.find("button");i.prop("disabled",!0),e.post(BASE_DIR+"rest/character/powers/delete",{delete_key:r,user_id:o.user_id,character_id:o.character_id},function(t){null!=t.success?($editPowerForm.trigger("reset"),$editPowerForm.find(".action-close").first().trigger("click"),e("#power-"+r).fadeOut("normal")):null!=t.error&&alert("Error: "+t.error),i.prop("disabled",!1)},"json")}),$equipmentForm.submit(function(t){t.preventDefault();var r=e(this).find("button"),o=e(this).serializeArray(),i=e(this).serializeObject();r.prop("disabled",!0),e.post(BASE_DIR+"rest/character/equipment/add",o,function(e){if(null!=e.success){$equipmentForm.trigger("reset"),$equipmentForm.find(".action-close").first().trigger("click");var t=JBTemplateEngine(equipmentTemplate,{key:$equipmentTable.find("tr").length,object:JSON.stringify(i),slot:i.slot.capitalize(),name:i.name,bonus:i.bonus,stat:i.stat.capitalize()});$equipmentTable.append(t)}else null!=e.error&&alert("Error: "+e.error);r.prop("disabled",!1)},"json")}),$editEquipmentForm.submit(function(t){t.preventDefault();var r=e(this).find("button"),o=e(this).serializeArray(),i=e(this).serializeObject(),n=$editEquipmentKey.val();r.prop("disabled",!0),e.post(BASE_DIR+"rest/character/equipment/edit",o,function(t){if(null!=t.success){$editEquipmentForm.trigger("reset"),$editEquipmentForm.find(".action-close").first().trigger("click");var o=e("#equipment-"+n);o.data("object",i),o.find(".slot span").html(i.slot),o.find(".name").html(i.name),o.find(".bonus").html("+"+i.bonus+" "+i.stat)}else null!=t.error&&alert("Error: "+t.error);r.prop("disabled",!1)},"json")}),$deleteEquipment.click(function(t){t.preventDefault();var r=$editEquipmentKey.val(),o=$editEquipmentForm.serializeObject(),i=$editEquipmentForm.find("button");i.prop("disabled",!0),e.post(BASE_DIR+"rest/character/equipment/delete",{delete_key:r,user_id:o.user_id,character_id:o.character_id},function(t){null!=t.success?($editEquipmentForm.trigger("reset"),$editEquipmentForm.find(".action-close").first().trigger("click"),e("#equipment-"+r).fadeOut("normal")):null!=t.error&&alert("Error: "+t.error),i.prop("disabled",!1)},"json")})}),jQuery(document).ready(function(e){$body=e("body"),$characterList=e("#character-list-target"),$addCharacter=e("#add-character"),$characterModal=e("#character-modal"),$characterForm=e("#character-form"),characterTemplate=e("#character-template").html(),$addCharacter.click(function(e){$characterModal.addClass("open")}),$characterForm.submit(function(t){t.preventDefault();var r=e(this).find("button"),o=e(this).serializeArray(),i=e(this).serializeObject();r.prop("disabled",!0),e.post(BASE_DIR+"rest/character/create",o,function(e){if(null!=e.success){$characterForm.trigger("reset"),$characterForm.find(".action-close").first().trigger("click");var t=JBTemplateEngine(characterTemplate,{character_id:e.character_id,type:"",name:i.character_name});$characterList.append(t)}else null!=e.error&&alert("Error: "+e.error);r.prop("disabled",!1)},"json")})}),jQuery(document).ready(function(e){$body=e("body"),$loginForms=e(".login-form"),$signinForm=e("#signin-form"),$signinBtns=e(".signin-btn"),$signupForm=e("#signup-form"),$signupBtns=e(".signup-btn"),$forgotForm=e("#forgot-form"),$forgotBtns=e(".forgot-btn"),$signinForm.submit(function(t){t.preventDefault();var r=e(this).serializeArray();jbUserFormSend("signin",r,$signinForm)}),$signupForm.submit(function(t){t.preventDefault();var r=e(this).serializeArray();jbUserFormSend("signup",r,$signinForm)}),$forgotForm.submit(function(t){t.preventDefault();var r=e(this).serializeArray();$forgotForm.find(".btn-primary").html('<i class="fal fa-circle-notch fa-spin"></i>').prop("disabled",!0),jbUserFormSend("forgot",r,$forgotForm)}),$signinBtns.click(function(e){$loginForms.removeClass("open"),$signinForm.addClass("open")}),$signupBtns.click(function(e){$loginForms.removeClass("open"),$signupForm.addClass("open")}),$forgotBtns.click(function(e){$loginForms.removeClass("open"),$forgotForm.addClass("open")})});