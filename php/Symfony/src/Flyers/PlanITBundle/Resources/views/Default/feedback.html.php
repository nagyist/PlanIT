<form id="project" name="project_choose" method="post" action="<?php echo $view['router']->generate('PlanITBundle_listFeedback'); ?>">
  <label for="project">Choose your project :</label>
  <select name="project" id="project">
  <?php foreach ($projects as $p) : ?>
    <option value="<?php echo $p->getIdproject(); ?>" onclick=" $('#feedback_result').load('<?php echo $view['router']->generate('PlanITBundle_resultFeedback'); ?>/<?php echo $p->getIdproject(); ?>') "><?php echo $p->getName(); ?></option>
  <?php endforeach; ?>
  </select>
</form>

<br /><br />

<div id="feedback_result"></div>
