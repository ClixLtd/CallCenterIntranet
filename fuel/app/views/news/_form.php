<?php echo Form::open(array('class' => 'form-stacked')); ?>

		<div class="clearfix">
			<?php echo Form::label('Title', 'title'); ?>

			<div class="input">
				<?php echo Form::input('title', Input::post('title', isset($news) ? $news->title : ''), array('class' => 'span6')); ?>

			</div>
		</div>
		<div class="clearfix">
			<?php echo Form::label('Article', 'article'); ?>

			<div class="input">
				<?php echo Form::textarea('article', Input::post('article', isset($news) ? $news->article : ''), array('class' => 'span10 wysiwyg large', 'rows' => 8)); ?>

			</div>
		</div>
		<div class="clearfix">
			<?php echo Form::label('Call center id', 'call_center_id'); ?>

			<div class="input">
				<?php echo Form::input('call_center_id', Input::post('call_center_id', isset($news) ? $news->call_center_id : ''), array('class' => 'span6')); ?>

			</div>
		</div>
		<div class="clearfix">
			<?php echo Form::label('User id', 'user_id'); ?>

			<div class="input">
				<?php echo Form::input('user_id', Input::post('user_id', isset($news) ? $news->user_id : ''), array('class' => 'span6')); ?>

			</div>
		</div>
		<div class="actions">
			<?php echo Form::submit('submit', 'Save', array('class' => 'btn primary')); ?>

		</div>
		
<?php echo Form::close(); ?>