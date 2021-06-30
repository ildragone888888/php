<?php
echo "
<body>
<form action='/2.php' method='POST'>
  <ul>
    <li>
      <label for='name'>Name:</label>
      <input type='text' name='name'>
    </li>
    <li>
      <label for='msg'>Message:</label>
      <textarea id='msg' name='message'></textarea>
    </li>
  </ul>
  <input type='submit' value='Выбрать'>
</form>
</body>
";
