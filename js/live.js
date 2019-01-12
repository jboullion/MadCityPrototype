function jbSetCookie(cname,cvalue,exdays){var d=new Date;d.setTime(d.getTime()+24*exdays*60*60*1e3);var expires="expires="+d.toUTCString();document.cookie=cname+"="+cvalue+";"+expires+";path=/"}function jbGetCookie(cname){for(var name=cname+"=",ca=document.cookie.split(";"),i=0;i<ca.length;i++){for(var c=ca[i];" "==c.charAt(0);)c=c.substring(1);if(0==c.indexOf(name))return c.substring(name.length,c.length)}return""}function jbDeleteCookie(cname){jbSetCookie(cname,"",-1)}function JBTemplateEngine(tpl,data){for(var key in data){var re=new RegExp("<%"+key+"%>","gi");tpl=tpl.replace(re,data[key])}return tpl}function resetForm($formElement){$formElement.find(".action-close").first().trigger("click"),setTimeout(function(){$formElement.trigger("reset")},ANIMATION_DURATION)}function confirmDelete($message){return confirm($message)}function debounce(func,wait,immediate){var timeout;return function(){var context=this,args=arguments,later=function(){timeout=null,immediate||func.apply(context,args)},callNow=immediate&&!timeout;clearTimeout(timeout),timeout=setTimeout(later,wait),callNow&&func.apply(context,args)}}function addPlayer(element){var $button=$(element),character_id=$button.data("id"),user_id=$button.data("user"),party_id=$("#add-player-party-id").val();$button.prop("disabled",!0),$.post(BASE_DIR+"rest/party/add",{party_id:party_id,character_id:character_id,user_id:user_id},function(result){if(null!=result.success){var newPlayer=JBTemplateEngine(playerTemplate,{party_id:party_id,user_id:result.player.user_id,user_name:result.player.user_name,user_email:result.player.user_email,character_id:result.player.character_id,character_name:result.player.character_name});$playerList.append(newPlayer),$button.parents(".list-group-item").fadeOut(ANIMATION_DURATION,function(){$(this).remove()})}else null!=result.error?(alert("Error: "+result.error),$button.prop("disabled",!1)):$button.prop("disabled",!0)},"json")}function googleSignIn(googleUser){var profile=googleUser.getBasicProfile(),id_token=googleUser.getAuthResponse().id_token,data={email:profile.getEmail(),id_token:id_token};jbSetCookie("google-idtoken",id_token,1),jbSetCookie("email",profile.getEmail(),1),jbUserFormSend("google-signin",data,$signinForm)}function jbSignOut(e,email){if(e.preventDefault(),gapi.auth2){var auth2=gapi.auth2.getAuthInstance();auth2.isSignedIn.get()?auth2.signOut().then(function(){auth2.disconnect(),jbDeleteSession(email)}):jbDeleteSession(email)}else jbDeleteSession(email);return!1}function jbDeleteSession(email){jbDeleteCookie("google-idtoken"),jbDeleteCookie("email"),email&&jQuery.post(BASE_DIR+"rest/user/logout",{email:email},function(result){result.success?window.location.href=window.location.protocol+"//"+window.location.hostname:console.log(result)})}function onLoad(){gapi.load("auth2",function(){gapi.auth2.init()})}function jbUserFormSend(script,data,$form){$.post(BASE_DIR+"rest/user/"+script,data,function(result){result.success?"forgot-form"==$form[0].id?($form.find(".alert-danger").addClass("hidden"),$form.find(".alert-success").html(result.success).removeClass("hidden")):(jbSetCookie("email",data.email,1),window.location.href=window.location.protocol+"//"+window.location.hostname+"/character/"):result.error?$form.find(".alert-danger").html(result.error).removeClass("hidden"):$form.find(".alert-danger").html("Unknown Error").removeClass("hidden"),"forgot-form"==$form[0].id&&$form.find(".btn-primary").html("Get New Password").prop("disabled",!1)},"json")}String.prototype.jbCleanNumber=function(){var returnValue=this.replace(/[^0-9.-]/g,"");return(isNaN(returnValue)||""==returnValue)&&(returnValue=0),returnValue},String.prototype.capitalize=function(){return this.charAt(0).toUpperCase()+this.slice(1)},String.prototype.replaceAll=function(search,replacement){return this.replace(new RegExp(search,"g"),replacement)},String.prototype.sanitize=function(){return this.replaceAll("/[^a-zA-Z0-9]/"," ")},Number.prototype.random=function(){var min=1,max=Math.floor(this);return Math.floor(Math.random()*(max-min+1))+min},Number.prototype.jbFormatMoney=function(c,d,t){var n=this,c=isNaN(c=Math.abs(c))?2:c,d=void 0==d?".":d,t=void 0==t?",":t,s=n<0?"-":"",i=parseInt(n=Math.abs(+n||0).toFixed(c))+"",j=(j=i.length)>3?j%3:0;return s+(j?i.substr(0,j)+t:"")+i.substr(j).replace(/(\d{3})(?=\d)/g,"$1"+t)+(c?d+Math.abs(n-i).toFixed(c).slice(2):"")},Number.prototype.round=function(decimals){var multiplier=Math.pow(10,decimals||0);return Math.round(this*multiplier)/multiplier},$.fn.serializeObject=function(){var o={},a=this.serializeArray();return $.each(a,function(){void 0!==o[this.name]?(o[this.name].push||(o[this.name]=[o[this.name]]),o[this.name].push(this.value||"")):o[this.name]=this.value||""}),o};var BASE_DIR="/";jQuery(document).ready(function($){$menu=$("#menu"),$shade=$("#menu-shade"),$toggle=$(".menu-toggle"),$numberInputs=$(".number-control"),$actionModals=$(".action-modal"),$actionContent=$(".action-content"),$actionClose=$(".action-close"),$toggle.click(function(e){console.log("click menu"),$menu.toggleClass("open"),$shade.toggleClass("open")}),$shade.click(function(e){$menu.removeClass("open"),$shade.removeClass("open")}),$numberInputs.on("input",function(){return this.value.length>this.maxLength&&(this.value=this.value.slice(0,this.maxLength))}),$actionContent.click(function(e){e.stopPropagation()}),$actionClose.click(function(e){$actionModals.removeClass("open")}),$actionModals.click(function(e){$(this).removeClass("open")})}),$(window).keydown(function(event){if(13==event.keyCode)return event.preventDefault(),!1}),jQuery(document).ready(function($){ANIMATION_DURATION=300,$body=$("body"),$characterSheet=$("#character-sheet"),$inputSaves=$(".character-save"),$deleteCharacterModal=$("#delete-character-modal"),$deleteCharacterForm=$("#delete-character-form"),$addPower=$("#add-power"),$powerModal=$("#power-modal"),$powerForm=$("#power-form"),$powerTable=$("#power-table tbody"),$editPowerModal=$("#edit-power-modal"),$editPowerForm=$("#edit-power-form"),$editPowerKey=$("#edit-power-key"),$deletePower=$("#delete-power"),powerTemplate=$("#power-template").html(),$addEquipment=$("#add-equipment"),$equipmentModal=$("#equipment-modal"),$equipmentForm=$("#equipment-form"),$equipmentTable=$("#equipment-table tbody"),$editEquipmentModal=$("#edit-equipment-modal"),$editEquipmentForm=$("#edit-equipment-form"),$editEquipmentKey=$("#edit-equipment-key"),$deleteEquipment=$("#delete-equipment"),equipmentTemplate=$("#equipment-template").html(),$increment=$(".increment"),$decrement=$(".decrement"),$diceToggle=$("#dice-toggle"),$diceShelf=$("#dice-shelf"),$actionDice=$(".action-dice"),$actionDiceResult=$("#dice-result"),$addPower.click(function(e){$powerModal.addClass("open")}),$diceToggle.click(function(e){$diceShelf.toggleClass("open")}),$body.on("click",".edit-power",function(e){var power=$(this).data("object"),key=$(this).data("key");$("#edit-power-name").val(power.name),$("#edit-power-type").val(power.type),$("#edit-power-stat").val(power.stat),$("#edit-power-damage").val(power.damage),$("#edit-power-effect").val(power.effect),$("#edit-power-duration").val(power.duration),$("#edit-power-desc").val(power.desc),$editPowerKey.val(key),$editPowerModal.addClass("open")}),$body.on("click",".edit-equipment",function(e){var equipment=$(this).data("object"),key=$(this).data("key");$("#edit-equipment-slot").val(equipment.slot),$("#edit-equipment-name").val(equipment.name),$("#edit-equipment-bonus").val(equipment.bonus),$("#edit-equipment-stat").val(equipment.stat),$("#edit-equipment-desc").val(equipment.desc),$editEquipmentKey.val(key),$editEquipmentModal.addClass("open")}),$body.on("click",".delete-character",function(e){e.preventDefault(),e.stopPropagation();var character_id=$(this).data("id"),character_name=$(this).data("name");return $("#delete-character-id").val(character_id),$("#delete-character-name").html(character_name),$deleteCharacterModal.addClass("open"),!1}),$addEquipment.click(function(e){$equipmentModal.addClass("open")}),$increment.click(function(e){var target=$(this).data("target"),currentVal=parseInt($("#"+target).val().jbCleanNumber())+1;currentVal<0&&(currentVal=0),$("#"+target).val(currentVal).trigger("change")}),$decrement.click(function(e){var target=$(this).data("target"),currentVal=parseInt($("#"+target).val().jbCleanNumber())-1;currentVal<0&&(currentVal=0),$("#"+target).val(currentVal).trigger("change")});var rollingTimer=null;$actionDice.click(function(e){e.preventDefault(),e.stopPropagation(),rolling=!0,rollingTimer&&clearTimeout(rollingTimer);var value=parseInt($(this).data("value"));$actionDiceResult.css("left",$(this).position().left).addClass("open").find("span").html(value.random()),rollingTimer=setTimeout(function(){$actionDiceResult.removeClass("open")},2e3)}),$characterSheet.submit(function(e){e.preventDefault();var data=$(this).serializeArray();$.post(BASE_DIR+"rest/character/update",data,function(result){},"json")}),$inputSaves.change(function(e){$characterSheet.trigger("submit")}),$powerForm.submit(function(e){e.preventDefault();var $buttons=$(this).find("button"),dataPost=$(this).serializeArray(),dataObject=$(this).serializeObject();console.log(dataObject),$buttons.prop("disabled",!0),$.post(BASE_DIR+"rest/character/powers/add",dataPost,function(result){if(null!=result.success){resetForm($powerForm);var newPower=JBTemplateEngine(powerTemplate,{key:$powerTable.find("tr").length,object:JSON.stringify(dataObject),type:dataObject.type,name:dataObject.name,damage:dataObject.damage,effect:dataObject.effect});$powerTable.append(newPower)}else null!=result.error&&alert("Error: "+result.error)},"json").done(function(){$buttons.prop("disabled",!1)})}),$editPowerForm.submit(function(e){e.preventDefault();var $buttons=$(this).find("button"),dataPost=$(this).serializeArray(),powerObject=$(this).serializeObject(),editKey=$editPowerKey.val();$buttons.prop("disabled",!0),$.post(BASE_DIR+"rest/character/powers/edit",dataPost,function(result){if(null!=result.success){resetForm($editPowerForm);var $editedPower=$("#power-"+editKey);$editedPower.data("object",powerObject),$editedPower.find(".type span").html(powerObject.type),$editedPower.find(".name").html(powerObject.name),$editedPower.find(".damage").html(powerObject.damage),$editedPower.find(".effect").html(powerObject.effect)}else null!=result.error&&alert("Error: "+result.error)},"json").done(function(){$buttons.prop("disabled",!1)})}),$deletePower.click(function(e){if(e.preventDefault(),!confirmDelete("Are you sure you want to delete this power?"))return!1;var deleteKey=$editPowerKey.val(),dataObject=$editPowerForm.serializeObject(),$buttons=$editPowerForm.find("button");$buttons.prop("disabled",!0),$.post(BASE_DIR+"rest/character/powers/delete",{delete_key:deleteKey,user_id:dataObject.user_id,character_id:dataObject.character_id},function(result){null!=result.success?(resetForm($editPowerForm),$("#power-"+deleteKey).fadeOut(ANIMATION_DURATION,function(){$(this).remove()})):null!=result.error&&alert("Error: "+result.error)},"json").done(function(){$buttons.prop("disabled",!1)})}),$equipmentForm.submit(function(e){e.preventDefault();var $buttons=$(this).find("button"),dataPost=$(this).serializeArray(),equipmentObject=$(this).serializeObject();$buttons.prop("disabled",!0),$.post(BASE_DIR+"rest/character/equipment/add",dataPost,function(result){if(null!=result.success){resetForm($equipmentForm);var newEquipment=JBTemplateEngine(equipmentTemplate,{key:$equipmentTable.find("tr").length,object:JSON.stringify(equipmentObject),slot:equipmentObject.slot.capitalize(),name:equipmentObject.name,bonus:equipmentObject.bonus,stat:equipmentObject.stat.capitalize()});$equipmentTable.append(newEquipment)}else null!=result.error&&alert("Error: "+result.error)},"json").done(function(){$buttons.prop("disabled",!1)})}),$editEquipmentForm.submit(function(e){e.preventDefault();var $buttons=$(this).find("button"),dataPost=$(this).serializeArray(),equipmentObject=$(this).serializeObject(),editKey=$editEquipmentKey.val();$buttons.prop("disabled",!0),$.post(BASE_DIR+"rest/character/equipment/edit",dataPost,function(result){if(null!=result.success){resetForm($editEquipmentForm);var $editedEquipment=$("#equipment-"+editKey);$editedEquipment.data("object",equipmentObject),$editedEquipment.find(".slot span").html(equipmentObject.slot),$editedEquipment.find(".name").html(equipmentObject.name),$editedEquipment.find(".bonus").html("+"+equipmentObject.bonus+" "+equipmentObject.stat)}else null!=result.error&&alert("Error: "+result.error)},"json").done(function(){$buttons.prop("disabled",!1)})}),$deleteEquipment.click(function(e){if(e.preventDefault(),!confirmDelete("Are you sure you want to delete this equipment?"))return!1;var deleteKey=$editEquipmentKey.val(),dataObject=$editEquipmentForm.serializeObject(),$buttons=$editEquipmentForm.find("button");$buttons.prop("disabled",!0),$.post(BASE_DIR+"rest/character/equipment/delete",{delete_key:deleteKey,user_id:dataObject.user_id,character_id:dataObject.character_id},function(result){null!=result.success?(resetForm($editEquipmentForm),$("#equipment-"+deleteKey).fadeOut("normal")):null!=result.error&&alert("Error: "+result.error)},"json").done(function(){$buttons.prop("disabled",!1)})}),$deleteCharacterForm.submit(function(e){if(e.preventDefault(),!confirmDelete("Are you sure you want to delete this character?"))return!1;var $buttons=$(this).find("button"),dataPost=$(this).serializeArray(),dataObject=$(this).serializeObject();return $buttons.prop("disabled",!0),$.post(BASE_DIR+"rest/character/delete",dataPost,function(result){null!=result.success?(resetForm($deleteCharacterForm),$("#character-"+dataObject.character_id).fadeOut(ANIMATION_DURATION,function(){$(this).remove()})):null!=result.error&&alert("Error: "+result.error)},"json").done(function(){$buttons.prop("disabled",!1)}),!1})}),jQuery(document).ready(function($){$body=$("body"),$characterList=$("#character-list-target"),$addCharacter=$("#add-character"),$characterModal=$("#character-modal"),$characterForm=$("#character-form"),characterTemplate=$("#character-template").html(),$addCharacter.click(function(e){$characterModal.addClass("open")}),$characterForm.submit(function(e){e.preventDefault();var $buttons=$(this).find("button"),dataPost=$(this).serializeArray(),dataObject=$(this).serializeObject();$buttons.prop("disabled",!0),$.post(BASE_DIR+"rest/character/create",dataPost,function(result){if(null!=result.success){resetForm($characterForm),$characterForm.find(".action-close").first().trigger("click");var newCharacter=JBTemplateEngine(characterTemplate,{character_id:result.character_id,type:"",name:dataObject.character_name});$characterList.append(newCharacter)}else null!=result.error&&alert("Error: "+result.error);$buttons.prop("disabled",!1)},"json")})}),jQuery(document).ready(function($){$body=$("body"),$partyList=$("#party-list-target"),$createParty=$("#create-party"),$partyModal=$("#create-party-modal"),$partyForm=$("#create-party-form"),$editPartyModal=$("#edit-party-modal"),$editPartyForm=$("#edit-party-form"),$editPartyID=$("#edit-party-id"),$deleteParty=$("#delete-party"),$playerList=$("#player-list-target"),$addPlayer=$("#add-player"),$addPlayerModal=$("#add-player-modal"),$addPlayerForm=$("#add-player-form"),addPlayerPartyID=$("#add-player-party-id").val(),addPlayerUserID=$("#add-player-user-id").val(),$addPlayerSearch=$("#add-player-search"),$addPlayerSearchTarget=$("#add-player-search-target"),$removePlayerModal=$("#remove-player-modal"),$removePlayerForm=$("#remove-player-form"),$removePlayerID=$("#remove-player-id"),partyTemplate=$("#party-template").html(),playerTemplate=$("#player-template").html(),playerSearchTemplate=$("#player-search-template").html(),$createParty.click(function(e){$partyModal.addClass("open")}),$addPlayer.click(function(e){$addPlayerModal.addClass("open")}),$body.on("click",".edit-party",function(e){e.preventDefault(),e.stopPropagation();var party_id=$(this).data("id"),party_name=$(this).data("name");return $("#edit-party-id").val(party_id),$("#edit-party-name").val(party_name),$editPartyModal.addClass("open"),!1}),$body.on("click",".remove-player",function(e){e.preventDefault(),e.stopPropagation();var user_id=$(this).data("id");return $removePlayerID.val(user_id),$removePlayerModal.addClass("open"),!1}),$partyForm.submit(function(e){e.preventDefault();var $buttons=$(this).find("button"),dataPost=$(this).serializeArray(),dataObject=$(this).serializeObject();$buttons.prop("disabled",!0),$.post(BASE_DIR+"rest/party/create",dataPost,function(result){if(null!=result.success){resetForm($partyForm);var newparty=JBTemplateEngine(partyTemplate,{party_id:result.party_id,party_name:dataObject.party_name,dm_email:dataObject.dm_email,next_session:"",last_online:""});$partyList.append(newparty)}else null!=result.error&&alert("Error: "+result.error)},"json").done(function(){$buttons.prop("disabled",!1)})}),$editPartyForm.submit(function(e){e.preventDefault();var $buttons=$(this).find("button"),dataPost=$(this).serializeArray();$buttons.prop("disabled",!0),$.post(BASE_DIR+"rest/party/edit",dataPost,function(result){if(null!=result.success){resetForm($editPartyForm);var updatedParty=JBTemplateEngine(partyTemplate,{party_id:result.party.party_id,party_name:result.party.party_name,dm_email:result.party.dm_email,next_session:"",last_online:""});$("#party-"+result.party.party_id).replaceWith(updatedParty)}else null!=result.error&&alert("Error: "+result.error)},"json").done(function(){$buttons.prop("disabled",!1)})}),$deleteParty.click(function(e){if(e.preventDefault(),!confirmDelete("Are you sure you want to delete this party?"))return!1;var party_id=$editPartyID.val(),dataObject=$editPartyForm.serializeObject(),$buttons=$editEquipmentForm.find("button");$buttons.prop("disabled",!0),$.post(BASE_DIR+"rest/party/delete",{party_id:party_id,user_id:dataObject.user_id,party_password:dataObject.party_password},function(result){null!=result.success?(resetForm($editPartyForm),$("#party-"+party_id).fadeOut("normal")):null!=result.error&&alert("Error: "+result.error)},"json").done(function(){$buttons.prop("disabled",!1)})});var searchPlayer=debounce(function(search){if(search.length>2){var dataPost=$addPlayerForm.serializeArray();$.get(BASE_DIR+"rest/party/search",dataPost,function(result){if($addPlayerSearchTarget.html(""),null!=result.success&&result.users.length>0)for(var i=0;i<result.users.length;i++){var newPlayer=JBTemplateEngine(playerSearchTemplate,{character_id:result.users[i].character_id,character_name:result.users[i].character_name,user_id:result.users[i].user_id});$addPlayerSearchTarget.append(newPlayer)}else null!=result.error&&(htmlResult='<li class="list-group-item">'+result.error+"</li>",$addPlayerSearchTarget.html(htmlResult))},"json")}},250);$addPlayerSearch.keyup(function(e){searchPlayer($(this).val())}),$removePlayerForm.submit(function(e){e.preventDefault();var $buttons=$(this).find("button"),dataPost=$(this).serializeArray(),dataObject=$(this).serializeObject();$buttons.prop("disabled",!0),$.post(BASE_DIR+"rest/party/remove",dataPost,function(result){null!=result.success?(resetForm($removePlayerForm),$("#player-"+dataObject.user_id).fadeOut(ANIMATION_DURATION,function(){$(this).remove()})):null!=result.error&&alert("Error: "+result.error)},"json").done(function(){$buttons.prop("disabled",!1)})})}),$playerList=$("#player-list-target");var deferredPrompt;"serviceWorker"in navigator&&navigator.serviceWorker.register("/serviceWorker.js").then(function(){}),window.addEventListener("beforeinstallprompt",function(event){return event.preventDefault(),deferredPrompt=event,!1}),jQuery(document).ready(function($){$body=$("body"),$loginForms=$(".login-form"),$signinForm=$("#signin-form"),$signinBtns=$(".signin-btn"),$signupForm=$("#signup-form"),$signupBtns=$(".signup-btn"),$forgotForm=$("#forgot-form"),$forgotBtns=$(".forgot-btn"),$signinForm.submit(function(e){e.preventDefault();var data=$(this).serializeArray();jbUserFormSend("signin",data,$signinForm)}),$signupForm.submit(function(e){e.preventDefault();var data=$(this).serializeArray();jbUserFormSend("signup",data,$signinForm)}),$forgotForm.submit(function(e){e.preventDefault();var data=$(this).serializeArray();$forgotForm.find(".btn-primary").html('<i class="fal fa-circle-notch fa-spin"></i>').prop("disabled",!0),jbUserFormSend("forgot",data,$forgotForm)}),$signinBtns.click(function(e){$loginForms.removeClass("open"),$signinForm.addClass("open")}),$signupBtns.click(function(e){$loginForms.removeClass("open"),$signupForm.addClass("open")}),$forgotBtns.click(function(e){$loginForms.removeClass("open"),$forgotForm.addClass("open")})});