<h4>Comments:</h4>
<div id="viewComments">
<?php foreach ($model->comments as $comment) { ?>
<?php echo $comment->user->username; ?> (<?php echo $comment->created; ?>): <br />
<?php echo CHtml::encode($comment->text); ?>
<hr />
<?php } ?>
</div>
<textarea rows="5" style="width:98%;" id="comment_text"></textarea>
<div style="text-align: right;">
    <input type="button" class="btn btn-primary" onClick="addComment()" value="Add Comment"/>
</div>
