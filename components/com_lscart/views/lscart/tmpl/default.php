<?php
defined('_JEXEC') or die();

$user = JFactory::getUser();
?>
<h1 class="uk-text-center-medium">Корзина покупок</h1>
<p class="uk-h4">2 простых шага, не больше 2 минут Вашего времени</p>

<nav class="uk-navbar uk-margin hidden-print" id="cart-controls-top">
	<div class="uk-navbar-flip" style="margin-right: 10px;">
		<ul class="uk-subnav uk-subnav-line" style="margin-top: auto;">
			<li>
				<a href="/spareparts">
					<i class="uk-icon-reply uk-icon-small uk-margin-right uk-icon-hover"></i>Продолжить выбор
				</a>
			</li>
			<li class="uk-hidden-small">
				<a href="#" onclick="window.print()">
				<i class="uk-icon-print uk-icon-small uk-margin-right uk-icon-hover"></i>Распечатать
				</a>
			</li>
			<li name="cart-clean">
				<a href="#" title="Очистить корзину">
				Очистить корзину<i class="uk-icon-close uk-icon-small uk-margin-left uk-icon-hover"></i>
				</a>
			</li>
		</ul>
	</div>
</nav>

<hr class="uk-article-divider">
<div id="product-list">
	<table class="uk-table">
		<thead>
			<tr>
				<td>Товар</td>
				<td></td>
				<td class="uk-text-center">Цена</td>
				<td class="uk-text-center">Количество</td>
				<td class="uk-text-center">Сумма</td>
				<td></td>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($this->cart->goods as $key => $item) { ?>
				<tr>
					<td><img src="/<?= $item->image;?>" width="120" height="90"></td>
					<td>
                        <?= $item->renderProductCode();?>
						<h2 class="uk-article-title">
							<a href="<?= $item->url;?>" target="_blank">
								<?= $item->title;?>
							</a>
						</h2>
						<?php if (isset($item->subTitle))
							echo '<p class="ls-sub-title">'.$item->subTitle.'</p>';
						?>
					</td>
					<td class="ls-price-second uk-text-center uk-table-middle"><?= $item->renderPrice($item->priceDelivery);?></td>
					<td class="uk-text-center uk-table-middle"><input type="number" name="cart-quantity" min="1"
					         value="<?= $item->quantity;?>" data-id="<?= $key;?>" style="width: 50px;"/></td>
					<td class="ls-price-second uk-text-center uk-table-middle"><?= $item->renderPrice($item->priceDelivery * $item->quantity);?></td>
					<td class="uk-text-center uk-table-middle"><i class="uk-icon-trash-o uk-icon-small uk-icon-hover" onclick="deleteItem(this)" id="<?= $key;?>"></i>
				</tr>
			<?php } ?>
		</tbody>
	</table>
</div>

<div id="cart-total" class="uk-grid">
    <div class="uk-width-medium-1-2 uk-hidden-small">
    </div>
	<div class="uk-width-1-2">
            <p class="uk-h4 uk-text-right">
                Общая стоимость товаров: <?= $this->cart->renderPrice($this->cart->summTotal); ?>
            </p>
        <div class="uk-panel uk-panel-box uk-panel-box-secondary">
            <p class="uk-h4 uk-text-right">
                Стоимость доставки в зону 1: <?= $this->cart->renderPrice($this->cart->priceDeliveryCity); ?>
            </p>
            <?php if ($this->cart->summTotal < Cart::LIMIT_DELIVERY_CITY) {
		        echo '<p class="uk-text-danger uk-text-right"><small>Подберите товары ещё на '.$this->cart->deltaDeliveryCity.' рублей и получите бесплатную доставку по СПб</small></p>';
	        }?>
        </div>
        <div class="uk-panel uk-panel-box uk-panel-box-secondary">
            <p class="uk-h4 uk-text-right">
                Стоимость доставки в города-спутники: <?= $this->cart->renderPrice($this->cart->priceDeliverySatellites); ?>
            </p>
	        <?php if ($this->cart->summTotal < Cart::LIMIT_DELIVERY_SATELLITES) {
		        echo '<p class="uk-text-danger uk-text-right"><small>Подберите товары ещё на '.$this->cart->deltaDeliverySatellites.' рублей и получите бесплатную доставку по городам-спутникам</small></p>';
	        }?>

        </div>
    </div>
</div>

<div class="uk-grid">
    <div class="uk-width-medium-1-2 uk-hidden-small">
        <div class="uk-panel uk-panel-box uk-panel-box-secondary hidden-print">
            <p class="uk-h4">Порядок оформления заказа.</p>
            <p>Для оформления заказа регистрация на сайте не требуется.</p>
            <p>После оформления заказа Вы получите СМС на указанный номер и письмо на почту (при указании email).</p>
            <p>В течение часа в рабочее время с Вами свяжется менеджер для уточнения всех параметров заказа, времени и адреса доставки.</p>
            <p><a href="/delivery" title="Подробный порядок оформления Заказа" target="_blank">Прочитать подробнее...</a></p>
        </div>
    </div>
    <div class="uk-width-medium-1-2 uk-width-small-1-1">
        <div class="uk-panel uk-panel-box hidden-print">
            <form class="uk-form uk-form-horizontal" method="post" id="form-order"
                  action="<?= JRoute::_('index.php?option=com_lscart&task=cart.save');?>"
                  enctype="multipart/form-data">
                <div class="uk-form-row">
                    <label class="uk-form-label" style="width: 120px" for="form-name">Ваше имя</label>
                    <input type="text" id="form-name" name="name"
                           value="<?= ($user->id) ? $user->name : '';?>"
                           placeholder="<?= ($user->id) ? '' : 'Ваше имя';?>" data-uk-tooltip />
                </div>
                <div class="uk-form-row">
                    <label class="uk-form-label" style="width: 120px" for="form-phone">Ваш телефон*</label>
                    <input type="tel" id="form-phone" name="phone" placeholder="Ваш телефон" />
                </div>
                <div class="uk-form-row">
                    <label class="uk-form-label" style="width: 120px" for="form-email">Ваш Email*</label>
                    <input type="email" id="form-email" name="email"
                           value="<?= ($user->id) ? $user->email : '';?>"
                           placeholder="<?= ($user->id) ? '' : 'Ваш Email';?>" />
                </div>
                <div class="uk-form-row">
                    <label class="" style="width: 120px" for="form-no-email">У меня нет Email</label>
                    <input type="checkbox" id="form-no-email" name="no-email" />
                </div>
                <p>Мы позвоним Вам для уточнения итоговой цены, времени и адреса доставки.</p>
                <div class="uk-form-row">
                    <label for="form-agree">Я согласен с <a href="/about-us/terms-of-use" target="_blank">Пользовательским соглашением</a></label>
                    <input type="checkbox" id="form-agree" name="agree" checked/>
                </div>
                <div>
                    <small>
                        Мы гарантируем, что Ваши данные не будут использованы для рассылки нежелательной информации и ни при каких условиях не будут переданы третьим лицам.
                    </small>
                </div>

                <div class="uk-form-row">
                    <button type="button" id="form-cart-save"
                            class="uk-button uk-button-large uk-button-success"
                            onclick="yaCounter46027323.reachGoal('ORDERCART')">Оформить заказ</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Окно сообщений -->
<div id="lscart-alert" class="uk-modal" style="overflow-y: scroll;">
	<div class="uk-modal-dialog">
		<button type="button" class="uk-modal-close uk-close"></button>
		<div class="uk-modal-header" id="alert-header"></div>
		<div  id="alert-body"></div>

		<div class="uk-modal-footer uk-text-right"></div>
	</div>
</div>

<script src="/components/com_lscart/assets/js/jquery.maskedinput.js"></script>
<script>
	jQuery(function($){
        $.mask.definitions['~']='[9]';
        $("#form-phone").mask("+7(~99) 999-99-99", {
            clearIfNotMatch: true,
            completed: function(){ alert("Вы ввели номер: " + this.val()); }
        });
	});
</script>

<script>
	'use strict';

	let isChanged = false;
	let isValidEmail = true;

	//Назначение обработчиков событий
	let elementSave = document.getElementById('form-cart-save');
	if (elementSave) {
		elementSave.addEventListener('click' , cartSave);
	}

	let formNoEmail = document.getElementById('form-no-email');
	if (formNoEmail) {
		formNoEmail.addEventListener('change', formChangeNoEmail);
	}

	let elementsClean = document.getElementsByName('cart-clean');
	for (let i = 0; i < elementsClean.length; i++) {
		elementsClean[i].addEventListener('click' , cartDeleteAll);
	}

	let elementsQuantity = document.getElementsByName('cart-quantity');
	for (let i = 0; i < elementsQuantity.length; i++) {
		elementsQuantity[i].addEventListener('change' , cartChangeQuantity);
	}

	function validEMail(email) {
		let pattern = /^[\w-\.]+@[\w-\.]+\.[a-z]{2,4}$/i;

		if (pattern.test(email)) {
			return true;
		} else {
			let target = event.target.parentNode;
			target.insertAdjacentHTML( "beforeBegin", '<div id="alert-email" class="uk-alert uk-alert-warning">Неправильный Email</div>');
			return false;
		}
	}

	function validPhone(phone) {
		let pattern = /^((8|\+7)[\- ]?)?(\(?\d{3}\)?[\- ]?)?[\d\- ]{7,10}$/;

		if (pattern.test(phone)) {
			return true;
		} else {
			let target = event.target.parentNode;
			target.insertAdjacentHTML( "beforeBegin", '<div id="alert-phone" class="uk-alert uk-alert-warning">Неправильный номер телефона</div>');
			return false;
		}
	}

	function cartSave(event) {

		//console.log(isValidEmail);
		let target = event.target;
		let parent = target.parentNode;

		let alertPhone = document.getElementById('alert-phone');
		if (alertPhone != null) {
			alertPhone.remove();
		}

		let alertEmail = document.getElementById('alert-email');
		if (alertEmail != null) {
			alertEmail.remove();
		}

		let name = document.getElementById('form-name').value;

		let phone = document.getElementById('form-phone').value;
		if (!validPhone(phone)) return;

		let email = document.getElementById('form-email').value;
		if (isValidEmail) {
			if (!validEMail(email)) return;
		}

		let xhr = new XMLHttpRequest();

		let body = '';
		if (name) {
			body = 'name=' + encodeURIComponent(name);
<!--			--><?php //$this->cart->setUserName();?>
			//body = 'name=' + name;
		}
		if (phone) {
			//phone = phone.substr(1,3) + '-' + phone.substr(6);
			//body += '&phone=' + phone.substr(1,3) + '-' + phone.substr(6);
            body += '&phone=' + phone.substr(3,3) + '-' + phone.substr(8);
		}
		if (isValidEmail) {
			body += '&email=' + encodeURIComponent(email);
			//body += '&email=' + email;
		}

		//console.log(body);
		xhr.open("POST", 'index.php?option=com_lscart&task=cart.save', true);
		xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
		xhr.send(body);

		xhr.onreadystatechange = function() {
			if (this.readyState != 4) return;

			if (xhr.status != 200) {
				alert(xhr.status + ': ' + xhr.statusText);
			}
			else {
				target.innerHTML = 'Заказ оформлен';

				let alertHeader = '<h2 class="uk-text-center">Ваш заказ отправлен</h2>';
				document.getElementById('alert-header').innerHTML = alertHeader;

				let alertBody = '';
				if (name) {
					alertBody = '<p class="uk-text-center">Уважаемый ' + name + '</p>';
				}
				alertBody += '<p class="uk-text-center">Мы перезвоним Вам в течение часа в рабочее время</p>';
				if (isValidEmail) {
					alertBody += '<p class="uk-text-center">Также мы отправили Вам подтверждение на ' + email + '</p>';
				}
				alertBody += '<p class="uk-text-center">Спасибо за обращение в Логан-Шоп</p>';
				document.getElementById('alert-body').innerHTML = alertBody;

				UIkit.modal("#lscart-alert").show();

                setTimeout(function () {
                    location.assign('index.php?option=com_cobalt&view=records&section_id=2:spareparts');
                }, 10000);

            }
		};
	}

	function cartChangeQuantity(event) {
		setTimeout(function () {
			if (isChanged == false) {
				isChanged = true;
				let target = event.target;
				let itemId = target.getAttribute("data-id");
				let itemQuantity = target.value;

				let xhr = new XMLHttpRequest();
				let body = 'item_id='+itemId+'&item_quantity='+itemQuantity;
				xhr.open("POST", 'index.php?option=com_lscart&task=cart.changeQuantity', true);
				xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
				xhr.send(body);

				xhr.onreadystatechange = function() {
					if (this.readyState != 4) return;

					if (xhr.status != 200) {
						alert(xhr.status + ': ' + xhr.statusText);
					} else {
						location.reload();
					}
				};
			}
		}, 1000);
	}

	function cartCalculate() {
		location.reload();
	}

	function cartDeleteAll() {
		let modal = UIkit.modal;
		modal.labels.Cancel = 'Отмена';
		modal.labels.Ok = 'Удалить';

		modal.confirm('Удалить все товары из корзины?', function () {
			let xhr = new XMLHttpRequest();
			xhr.open("POST", 'index.php?option=com_lscart&task=cart.deleteAll', true);
			xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
			xhr.send();

			xhr.onreadystatechange = function() {
				if (this.readyState != 4) return;
				console.log(xhr.status);
				if (xhr.status == 200) {
					location.assign('/spareparts');
				}
				else {
					confirm(xhr.status + ': ' + xhr.statusText);
				}
			};
		});
	}

	function deleteItem(item) {
		let modal = UIkit.modal;
		//console.log(modal.labels);
		modal.labels.Cancel = 'Отмена';
		modal.labels.Ok = 'Удалить';
		modal.confirm('Удалить этот элемент?',
			function ()
			{
				let recordId = item.getAttribute("id");
				let d = item.parentNode.parentNode;

				let xhr = new XMLHttpRequest();
				let body = 'item_id='+recordId;
				xhr.open("POST", 'index.php?option=com_lscart&task=cart.delete', true);
				xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
				xhr.send(body);

				xhr.onreadystatechange = function() {
					if (this.readyState != 4) return;
					console.log(xhr.status);

					if (xhr.status == 200) {
						location.reload();
					} else {
						alert(xhr.status + ': ' + xhr.statusText);
					}
				};
			}
		);
	}

	function formChangeNoEmail() {
		let formEmail = document.getElementById('form-email');
		if (formNoEmail.checked == true) {
			formEmail.setAttribute('disabled', true);
			isValidEmail = false;
		}
		else {
			formEmail.removeAttribute('disabled');
			isValidEmail = true;
		}
	}
</script>
