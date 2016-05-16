<!-- contact section -->
<section class="" id="contact">
    <div class="container-fluid">
        <div class="row row-centered">
			<div class="contact text-center col-centered col-md-6 col-sm-8 col-xs-12">
				<h4>Связаться с нами</h4>
				<!-- end of contact section -->
				<?=Form::open('message/send', 
					[
						'method'=>'POST',
						'class'=>'form-horizontal form-contact',
						'role'=>'form'
					]
				)?>
				
					<div class="form-group">
						<?=Form::label('username', 'Представьтесь', 
							[
								'class'	=> 'control-label col-sm-3',
							]
						)?>
					    <div class="col-sm-9">
					        <?=Form::input('username', (isset($_POST['username'])?$_POST['username']:''), 
								[
									'class'	=> 'form-control',
									'placeholder'	=> 'Как к Вам обращаться',
								]
							)?>
					      
					    </div>
					</div>
					
					<div class="form-group">
						<?=Form::label('useremail', 'Контактный Email', 
							[
								'class'	=> 'control-label col-sm-3',
							]
						)?>
					    <div class="col-sm-9">
					        <?=Form::input('useremail', (isset($_POST['useremail'])?$_POST['useremail']:''), 
								[
									'class'	=> 'form-control',
									'placeholder'	=> 'Контактный Email',
									'type'	=> 'email'
								]
							)?>
					      
					    </div>
					</div>
					
					<div class="form-group">
						<?=Form::label('usermessage', 'Сообщение', 
							[
								'class'	=> 'control-label col-sm-3',
							]
						)?>
					    <div class="col-sm-9">
					        <?=Form::textarea('usermessage', (isset($_POST['usermessage'])?$_POST['usermessage']:''), 
								[
									'class'	=> 'form-control',
									'placeholder'	=> 'Оставьте свое сообщение',
								]
							)?>
					      
					    </div>
					</div>
				
				<?=Form::close()?>
			</div>
        </div>
    </div>
</section>