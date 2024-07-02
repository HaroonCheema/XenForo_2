<?php
return array (
  'rtc_command_desc.ban' => 'Opens the form for managing bans in the room.
<br><br>

Options:<br>
<code class="bbCodeInline">--list</code> – Displays a list of banned users.<br>
<code class="bbCodeInline">--lift</code> – Displays a form for lift a ban from a user.
<br><br>

Usage example: <code class="bbCodeInline">/ban --list</code>',
  'rtc_command_desc.clear' => 'Delete messages in the room.
<br><br>

Options:<br>
<code class="bbCodeInline">--user</code> – username to delete messages only from specific user.
<br><br>

Usage example: <code class="bbCodeInline">/clear --user="Spammer"</code> ',
  'rtc_command_desc.destroy' => 'Completely deletes the room.',
  'rtc_command_desc.edit' => 'Opens the room editing form.',
  'rtc_command_desc.help' => 'Displays a list of available commands.',
  'rtc_command_desc.leave' => 'Leave the room.',
  'rtc_command_desc.link' => 'Generates a new invite link for the room.
<br><br>

Options:<br>
<code class="bbCodeInline">--refresh</code> – deletes all previous links.
<br><br>

Usage example:  <code class="bbCodeInline">/link --refresh</code> ',
  'rtc_command_desc.messages' => 'Enables / disables messages in the room.
<br><br>

Options:<br>
<code class="bbCodeInline">--on</code> – enables messages.<br>
<code class="bbCodeInline">--off</code> – disables messages.
<br><br>

Usage example: <code class="bbCodeInline">/messages --off</code> ',
  'rtc_command_desc.pm' => 'Sends a message in private messages to the user.
<br><br>
Usage example: <code class="bbCodeInline">/pm Bro, hi</code>',
  'rtc_command_desc.to' => 'Addresses a message to the user.
<br><br>
Usage example: <code class="bbCodeInline">/to Bro, hi</code> ',
);