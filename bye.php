<?php $name = $request->get('name', 'World'); ?>
Goodbye <?php echo htmlspecialchars($name, ENT_QUOTES, 'UTF-8'); ?>!