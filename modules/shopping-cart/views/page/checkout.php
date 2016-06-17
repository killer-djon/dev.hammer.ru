<!-- panel for checkout -->

<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title">
            <a data-toggle="collapse" data-parent="#accordion" data-target="#shopping-checkout">
                Контактные данные
            </a>
        </h3>
    </div>
    <div id="shopping-checkout" class="panel-collapse collapse">
        <div class="panel-body card">
			<form data-toggle="validator" role="form" class="form" id="personal-data" action="/cart/checkout" method="POST">
				<div class="row row-centered">
					<div class="col-md-10 col-centered text-center">
						<p>Поля отмеченные знаком <span class="text-danger"><strong>*</strong></span>, являются обязательными для заполнения.</p>
					</div>

					<!-- first parts to user data form -->
					<div class="col-md-5 col-sm-6 col-xs-12 col-centered">
						<!-- User name full|mixed -->
						<div class="form-group">
							<label for="username">Представьтесь:&nbsp;&nbsp;<span class="text-danger"><strong>*</strong></span></label>
							<div class="input-group">
										<span class="input-group-addon">
											<i class="fa fa-user"></i>
										</span>
								<input type="text" class="form-control" id="username" name="username" value="<?=(!empty($userdata['username']) ? $userdata['username'] : '')?>" required>
							</div>
							<div class="help-block with-errors"></div>
						</div>
						<!-- User name full|mixed -->

						<!-- Correct user Email -->
						<div class="form-group">
							<label for="useremail">Контактный Email:&nbsp;&nbsp;<span class="text-danger"><strong>*</strong></span></label>
							<div class="input-group">
								<span class="input-group-addon">@</span>
								<input placeholder="example@domain.ltd" type="email" class="form-control" id="useremail" name="useremail" data-error="Не заполнено поле или некорректный Email" value="<?=(!empty($userdata['useremail']) ? $userdata['useremail'] : '')?>" required>
							</div>
							<div class="help-block with-errors"></div>
						</div>
						<!-- Correct user Email -->

						<!-- Phone number -->
						<div class="form-group">
							<label for="userphone">Телефон для связи:</label>
							<div class="input-group">
										<span class="input-group-addon">
											<i class="fa fa-phone"></i>
										</span>
								<input type="tel" class="form-control" id="userphone" name="userphone" placeholder="79031234567" value="<?=(!empty($userdata['userphone']) ? $userdata['userphone'] : '')?>">
							</div>
							<div class="help-block with-errors"><em>Формат: 79031234567</em></div>
						</div>
						<!-- Phone number -->

					</div>
					<!-- first parts to user data form -->

					<!-- second parts to user data form -->
					<div class="col-md-5 col-sm-6 col-xs-12 col-centered">
						<!-- Phone number -->
						<div class="form-group">
							<label for="usermessage">Комментарий к заказу:</label>
							<div class="input-group">
										<span class="input-group-addon">
											<i class="fa fa-comment "></i>
										</span>
								<textarea class="form-control" rows="4" id="usermessage" name="usermessage" placeholder="Вы можете указать дополнительные пожелания к Вашему заказу, и мы обязательно их учтем" style="resize: none;"><?=(!empty($userdata['usermessage']) ? $userdata['usermessage'] : '')?></textarea>
							</div>
						</div>
						<!-- Phone number -->

						<!-- Country -->
						<div class="form-group">
							<label for="usercity">Город:</label>
							<input class="form-control" type="text" name="usercity" id="usercity" placeholder="Москва" value="<?=(!empty($userdata['usercity']) ? $userdata['usercity'] : '')?>">
							<div class="help-block with-errors"><em>С какого Вы города?</em></div>
						</div>
						<!-- Country -->
					</div>
					<!-- second parts to user data form -->
				</div>
				<br />
				<br />
				<div class="form-group text-center">
					<button type="submit" class="btn btn-primary">Оформить заказ</button>
				</div>
			</form>
        </div>
    </div>
</div>
<!-- panel for checkout -->