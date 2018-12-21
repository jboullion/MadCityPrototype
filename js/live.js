function jbSetCookie(e,t,o){var i=new Date;i.setTime(i.getTime()+24*o*60*60*1e3);var r="expires="+i.toUTCString();document.cookie=e+"="+t+";"+r+";path=/"}function jbGetCookie(e){for(var t=e+"=",o=document.cookie.split(";"),i=0;i<o.length;i++){for(var r=o[i];" "==r.charAt(0);)r=r.substring(1);if(0==r.indexOf(t))return r.substring(t.length,r.length)}return""}function jbDeleteCookie(e){setCookie(e,"",-1)}function JBTemplateEngine(e,t){for(var o in t){var i=new RegExp("<%"+o+"%>","gi");e=e.replace(i,t[o])}return e}function googleSignIn(e){var t=e.getBasicProfile(),o=e.getAuthResponse().id_token,i={email:t.getEmail(),id_token:o};jbUserFormSend("google-signin",i,$signinForm)}function jbSignOut(){var e=gapi.auth2.getAuthInstance();if(e.isSignedIn.get()){var t=e.currentUser.get().getBasicProfile();console.log("ID: "+t.getId()),console.log("Full Name: "+t.getName()),console.log("Given Name: "+t.getGivenName()),console.log("Family Name: "+t.getFamilyName()),console.log("Image URL: "+t.getImageUrl()),console.log("Email: "+t.getEmail()),e.signOut().then(function(){console.log("User signed out."),$.post(BASE_DIR+"rest/user/logout",{id_token:id_token,email:t.getEmail()},function(e){window.location.href=window.location.protocol+"//"+window.location.hostname})})}else $.post(BASE_DIR+"rest/user/logout",function(e){window.location.href=window.location.protocol+"//"+window.location.hostname})}function onLoad(){gapi.load("auth2",function(){gapi.auth2.init()})}function jbUserFormSend(e,t,o){$.post(BASE_DIR+"rest/user/"+e,t,function(e){e.success?"forgot-form"==o[0].id?(o.find(".alert-danger").addClass("hidden"),o.find(".alert-success").html(e.success).removeClass("hidden")):window.location.href=window.location.protocol+"//"+window.location.hostname+"/character/":e.error?o.find(".alert-danger").html(e.error).removeClass("hidden"):o.find(".alert-danger").html("Unknown Error").removeClass("hidden"),"forgot-form"==o[0].id&&o.find(".btn-primary").html("Get New Password").prop("disabled",!1)},"json")}String.prototype.jbCleanNumber=function(){var e=this.replace(/[^0-9.-]/g,"");return(isNaN(e)||""==e)&&(e=0),e},String.prototype.capitalize=function(){return this.charAt(0).toUpperCase()+this.slice(1)},Number.prototype.jbFormatMoney=function(e,t,o){var i=this,e=isNaN(e=Math.abs(e))?2:e,t=void 0==t?".":t,o=void 0==o?",":o,r=i<0?"-":"",n=parseInt(i=Math.abs(+i||0).toFixed(e))+"",a=(a=n.length)>3?a%3:0;return r+(a?n.substr(0,a)+o:"")+n.substr(a).replace(/(\d{3})(?=\d)/g,"$1"+o)+(e?t+Math.abs(i-n).toFixed(e).slice(2):"")},String.prototype.replaceAll=function(e,t){return this.replace(new RegExp(e,"g"),t)},Number.prototype.random=function(){var e=1,t=Math.floor(this);return Math.floor(Math.random()*(t-e+1))+e},Number.prototype.round=function(e){var t=Math.pow(10,e||0);return Math.round(this*t)/t},$.fn.serializeObject=function(){var e={},t=this.serializeArray();return $.each(t,function(){void 0!==e[this.name]?(e[this.name].push||(e[this.name]=[e[this.name]]),e[this.name].push(this.value||"")):e[this.name]=this.value||""}),e},window.scrollTo(0,1);var BASE_DIR="/";jQuery(document).ready(function(e){$menu=e("#menu"),$shade=e("#menu-shade"),$toggle=e(".menu-toggle"),$numberInputs=e(".number-control"),$actionModals=e(".action-modal"),$actionContent=e(".action-content"),$actionClose=e(".action-close"),$toggle.click(function(e){$menu.toggleClass("open"),$shade.toggleClass("open")}),$shade.click(function(e){$menu.removeClass("open"),$shade.removeClass("open")}),$numberInputs.on("input",function(){return this.value.length>this.maxLength&&(this.value=this.value.slice(0,this.maxLength))}),$actionContent.click(function(e){e.stopPropagation()}),$actionClose.click(function(e){$actionModals.removeClass("open")}),$actionModals.click(function(t){e(this).removeClass("open")})}),jQuery(document).ready(function(e){$body=e("body"),$characterSheet=e("#character-sheet"),$inputSaves=e(".character-save"),$rollers=e(".roller"),$rollerModal=e("#roller-modal"),$mutate=e(".mutate"),$mutateModal=e("#mutate-modal"),$addPower=e("#add-power"),$powerModal=e("#power-modal"),$powerForm=e("#power-form"),$powerTable=e("#power-table tbody"),$editPowerModal=e("#edit-power-modal"),$editPowerForm=e("#edit-power-form"),$editPowerKey=e("#edit-power-key"),$deletePower=e("#delete-power"),powerTemplate=e("#power-template").html(),$addEquipment=e("#add-equipment"),$equipmentModal=e("#equipment-modal"),$equipmentForm=e("#equipment-form"),$equipmentTable=e("#equipment-table tbody"),$editEquipmentModal=e("#edit-equipment-modal"),$editEquipmentForm=e("#edit-equipment-form"),$editEquipmentKey=e("#edit-equipment-key"),$deleteEquipment=e("#delete-equipment"),equipmentTemplate=e("#equipment-template").html(),$increment=e(".increment"),$decrement=e(".decrement"),$actionDice=e(".action-dice"),$actionDiceResult=e("#dice-result"),$rollers.click(function(e){$rollerModal.addClass("open")}),$mutate.click(function(e){$mutateModal.addClass("open")}),$addPower.click(function(e){$powerModal.addClass("open")}),$body.on("click",".edit-power",function(t){var o=e(this).data("object"),i=e(this).data("key");if(o.level)var r=o.level;else var r=1;e("#edit-power-level").val(r),e("#edit-power-type").val(o.type),e("#edit-power-name").val(o.name),e("#edit-power-damage").val(o.damage),e("#edit-power-effect").val(o.effect),e("#edit-power-desc").val(o.desc),$editPowerKey.val(i),$editPowerModal.addClass("open")}),$body.on("click",".edit-equipment",function(t){var o=e(this).data("object"),i=e(this).data("key");e("#edit-equipment-slot").val(o.slot),e("#edit-equipment-name").val(o.name),e("#edit-equipment-bonus").val(o.bonus),e("#edit-equipment-stat").val(o.stat),e("#edit-equipment-desc").val(o.desc),$editEquipmentKey.val(i),$editEquipmentModal.addClass("open")}),$addEquipment.click(function(e){$equipmentModal.addClass("open")}),$increment.click(function(t){var o=e(this).data("target"),i=parseInt(e("#"+o).val().jbCleanNumber())+1;i<0&&(i=0),e("#"+o).val(i).trigger("change")}),$decrement.click(function(t){var o=e(this).data("target"),i=parseInt(e("#"+o).val().jbCleanNumber())-1;i<0&&(i=0),e("#"+o).val(i).trigger("change")});var t=null;$actionDice.click(function(o){o.preventDefault(),o.stopPropagation(),rolling=!0,t&&clearTimeout(t);var i=parseInt(e(this).data("value"));$actionDiceResult.css("left",e(this).position().left).addClass("open").find("span").html(i.random()),t=setTimeout(function(){$actionDiceResult.removeClass("open")},2e3)}),$characterSheet.submit(function(t){t.preventDefault();var o=e(this).serializeArray();e.post(BASE_DIR+"rest/character/update",o,function(e){},"json")}),$inputSaves.change(function(e){$characterSheet.trigger("submit")}),$powerForm.submit(function(t){t.preventDefault();var o=e(this).find("button"),i=e(this).serializeArray(),r=e(this).serializeObject();o.prop("disabled",!0),e.post(BASE_DIR+"rest/character/powers/add",i,function(e){if(null!=e.success){$powerForm.trigger("reset"),$powerForm.find(".action-close").first().trigger("click");var t=JBTemplateEngine(powerTemplate,{key:$powerTable.find("tr").length,object:JSON.stringify(r),type:r.type,name:r.name,damage:r.damage,effect:r.effect});$powerTable.append(t)}else null!=e.error&&alert("Error: "+e.error);o.prop("disabled",!1)},"json")}),$editPowerForm.submit(function(t){t.preventDefault();var o=e(this).find("button"),i=e(this).serializeArray(),r=e(this).serializeObject(),n=$editPowerKey.val();o.prop("disabled",!0),e.post(BASE_DIR+"rest/character/powers/edit",i,function(t){if(null!=t.success){$editPowerForm.trigger("reset"),$editPowerForm.find(".action-close").first().trigger("click");var i=e("#power-"+n);i.data("object",r),i.find(".type span").html(r.type),i.find(".name").html(r.name),i.find(".damage").html(r.damage),i.find(".effect").html(r.effect)}else null!=t.error&&alert("Error: "+t.error);o.prop("disabled",!1)},"json")}),$deletePower.click(function(t){t.preventDefault();var o=$editPowerKey.val(),i=$editPowerForm.serializeObject(),r=$editPowerForm.find("button");r.prop("disabled",!0),e.post(BASE_DIR+"rest/character/powers/delete",{delete_key:o,user_id:i.user_id,character_id:i.character_id},function(t){null!=t.success?($editPowerForm.trigger("reset"),$editPowerForm.find(".action-close").first().trigger("click"),e("#power-"+o).fadeOut("normal")):null!=t.error&&alert("Error: "+t.error),r.prop("disabled",!1)},"json")}),$equipmentForm.submit(function(t){t.preventDefault();var o=e(this).find("button"),i=e(this).serializeArray(),r=e(this).serializeObject();o.prop("disabled",!0),e.post(BASE_DIR+"rest/character/equipment/add",i,function(e){if(null!=e.success){$equipmentForm.trigger("reset"),$equipmentForm.find(".action-close").first().trigger("click");var t=JBTemplateEngine(equipmentTemplate,{key:$equipmentTable.find("tr").length,object:JSON.stringify(r),slot:r.slot.capitalize(),name:r.name,bonus:r.bonus,stat:r.stat.capitalize()});$equipmentTable.append(t)}else null!=e.error&&alert("Error: "+e.error);o.prop("disabled",!1)},"json")}),$editEquipmentForm.submit(function(t){t.preventDefault();var o=e(this).find("button"),i=e(this).serializeArray(),r=e(this).serializeObject(),n=$editEquipmentKey.val();o.prop("disabled",!0),e.post(BASE_DIR+"rest/character/equipment/edit",i,function(t){if(null!=t.success){$editEquipmentForm.trigger("reset"),$editEquipmentForm.find(".action-close").first().trigger("click");var i=e("#equipment-"+n);i.data("object",r),i.find(".slot span").html(r.slot),i.find(".name").html(r.name),i.find(".bonus").html("+"+r.bonus+" "+r.stat)}else null!=t.error&&alert("Error: "+t.error);o.prop("disabled",!1)},"json")}),$deleteEquipment.click(function(t){t.preventDefault();var o=$editEquipmentKey.val(),i=$editEquipmentForm.serializeObject(),r=$editEquipmentForm.find("button");r.prop("disabled",!0),e.post(BASE_DIR+"rest/character/equipment/delete",{delete_key:o,user_id:i.user_id,character_id:i.character_id},function(t){null!=t.success?($editEquipmentForm.trigger("reset"),$editEquipmentForm.find(".action-close").first().trigger("click"),e("#equipment-"+o).fadeOut("normal")):null!=t.error&&alert("Error: "+t.error),r.prop("disabled",!1)},"json")})}),jQuery(document).ready(function(e){$body=e("body"),$loginForms=e(".login-form"),$signinForm=e("#signin-form"),$signinBtns=e(".signin-btn"),$signupForm=e("#signup-form"),$signupBtns=e(".signup-btn"),$forgotForm=e("#forgot-form"),$forgotBtns=e(".forgot-btn"),$signinForm.submit(function(t){t.preventDefault();var o=e(this).serializeArray();jbUserFormSend("signin",o,$signinForm)}),$signupForm.submit(function(t){t.preventDefault();var o=e(this).serializeArray();jbUserFormSend("signup",o,$signinForm)}),$forgotForm.submit(function(t){t.preventDefault();var o=e(this).serializeArray();$forgotForm.find(".btn-primary").html('<i class="fal fa-circle-notch fa-spin"></i>').prop("disabled",!0),jbUserFormSend("forgot",o,$forgotForm)}),$signinBtns.click(function(e){$loginForms.removeClass("open"),$signinForm.addClass("open")}),$signupBtns.click(function(e){$loginForms.removeClass("open"),$signupForm.addClass("open")}),$forgotBtns.click(function(e){$loginForms.removeClass("open"),$forgotForm.addClass("open")})});