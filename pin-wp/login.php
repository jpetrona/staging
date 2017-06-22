<?php
$flag = false;
$displayName = '';
if(is_user_logged_in()){
  $flag = true;
  $current_user = wp_get_current_user();
  $displayName = $current_user->display_name;
}?>
<div id="response-div" style="display: none;"></div>
<form id="msg_form" style="display: <?php echo $flag == true ? 'block': 'none' ;?>" >
  <input type="text" onKeyDown="return checkSubmit(event,'msg_send')"  class="msg-type" size="30" name="msg" id="msg">
  <input type="hidden" name="sendername" id="sendername" value="<?php echo $displayName ;?>">
  <input type="hidden" id="senderID" value="<?php echo (get_current_user_id() != '') ? get_current_user_id() : 0; ?>" name="senderID">
  <a href="javascript:void(0)" class="send_msg">Send</a>
</form>
<form action="" class='chat-form' style="display: <?php echo $flag == true ? 'none': 'block' ;?>" >
  <div onKeyDown="return checkSubmit(event,'start_chat')">Your Name : <input name="name" class="chat-user-name " id="name" placeholder="A Name Please"/></div>
  <!--<input type="submit" class="user_vote" value="Submit & Start Chatting">-->
  <a href="javascript:void(0)" class="user_vote">Submit & Start Chatting</a>
</form>
