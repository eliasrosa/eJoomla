jQuery.fn.extend({
	/* ********************************************************************************************************
	* Validar formulários
	*
	* @author Elias da Rosa <elias at caiac dot com dot br>
	* @author Frederico Machado <fredi at caiac dot com dot br>
	* @copyright 2008 (c) Caiac Soluções Para Internet Ltda.
	* @link http://www.caiac.com.br
	*
	* @version 1.0.13
	* @update: 23/06/2009
	*
	* *********************************************************************************************************/

	validaForm: function(parametros){
		var options = {
			error: function(campos, callback) {
				var msg = "Preencha corretamente o(s) seguinte(s) campo(s):\n";
				$(campos).each(function(){
					var titulo = (this.title != '') ? this.title : this.name;
					msg += "\n- "+ titulo;
				});
				alert(msg);
				op.callback.call(this);
			},
			mask: true,
			success: function(){},
			callback: function(){},
			callstart: function(){},
			upload: false,
			type: ''
		};

		var op = jQuery.extend(options, parametros);

		var caracterObrigatorio = '_';
		var camposErrados = new Array();

		var tipo = function(campo) {
			var r = $(campo).attr('rel');
			if(isObrigatorio(campo)) r = r.substr(0, r.length -1);
			return r;
		};

		var isObrigatorio = function(campo) {
			ob = $(campo).attr('rel');
			if(ob.substr(ob.length -1) == caracterObrigatorio) return true;
			return false;
		};

		var validar = function(campo, exp) {
			var  name = $(campo).attr('name');
			var value = $(campo).val();
			if(!exp.test(value)) camposErrados.push(campo);
		};

		return this.each(function(){

			var form = $(this);

			if (op.mask){
				// Busca todos os campos input e ativa os plugins/Mascaras
				var t = $(":input[rel]", form).length;
				$(":input[rel]", form).each(function(){
					switch (tipo(this)){
						case 'date':
							$(this).bind('keypress', function(){ return false; });
							$(this).datepicker();
							break;

						case 'cpf':
							$(this).setMask({ mask : '999.999.999-99' });
							break;

						case 'cnpj':
							$(this).setMask({ mask : '99.999.999/9999-99' });
							break;

						case 'cep':
							$(this).setMask({ mask : '99999-999' });
							break;

						case 'phone':
							$(this).setMask({ mask : '(99) 9999-9999' });
							break;

						case 'moeda':
							$(this).setMask({ mask : '99,999.999.999.999', type : 'reverse', defaultValue : '+000' });
							break;

						case 'time':
							$(this).setMask({ mask : '29:69' });
							break;

					}
				});
			}

			$(form).unbind("submit");

			$(form).bind("submit", function(){

				camposErrados = new Array();

				op.callstart.call(form);

				// Busca todos os campos input text
				$(":input[rel]", form).each(function() {
					switch (tipo(this)) {

						case 'email':
							if(isObrigatorio(this))
								validar(this, /^([\w]+)(\.[\w]+)*@([\w\-]+)(\.[\w]{2,7})(\.[a-z]{2})?$/i);
							break;

						case 'date':
							if(isObrigatorio(this))
								validar(this, /^\d{2}\/\d{2}\/\d{4}$/);
							break;

						case 'text':
							if(isObrigatorio(this))
								validar(this, /\S+/);
							break;

						case 'cpf':
							if(isObrigatorio(this))
								validar(this, /^\d{3}\.\d{3}\.\d{3}\-\d{2}$/);
							break;

						case 'cnpj':
							if(isObrigatorio(this))
								validar(this, /^\d{2}.\d{3}\.\d{3}\/\d{4}\-\d{2}$/);
							break;

						case 'cep':
							if(isObrigatorio(this))
								validar(this, /(^\d{5}-\d{3}$)/);
							break;

						case 'phone':
							if(isObrigatorio(this))
								validar(this, /\S+/);
							break;

						case 'integer':
							//numero inteiro, negativo ou positivo
							if(isObrigatorio(this))
								validar(this, /^-?\d+$/);
							break;

						case 'integerp':
							//numero inteiro, somente positivo
							if(isObrigatorio(this))
								validar(this, /^\d+$/);
							break;

						case 'moeda':
							if(isObrigatorio(this))
								validar(this, /^(\d{1,3})|(\.)(\,\d{2})$/);
							break;

						case 'float':
							if(isObrigatorio(this))
								validar(this, /^((\d*)|(\d*\.\d{2}))$/);
							break;

						case 'password':
							if(isObrigatorio(this))
								validar(this, /\S{6}/);
							break;

					}

				});

				//finalizando
				if(camposErrados.length == 0 ){

					// se o upload tiver ativado
					if (op.upload) {

						// gera o nome do iframe
						var iframeName = 'upload_' + Math.round(Math.random() * 999999);

						// cria o iframe dentro do body
						$('body').append('<iframe name="' + iframeName + '" id="' + iframeName + '" width="0" height="0" style="display:none;"></iframe>');

						// corrige o bug do IE
						window.frames[iframeName].name = iframeName;

						// cria os atributos do form
						form.attr({
							method: 'post',
							target: iframeName,
							enctype: 'multipart/form-data',
							encoding: 'multipart/form-data' // corrige o bug do IE
						});

						$('#' + iframeName).bind('load', function(){

							// remove o evento do iframe
							$('#' + iframeName).unbind('load');

							// captura a resposta
							var resposta = window.frames[0].document.body.innerHTML;

							setTimeout(function(){

								// remove o iframe
								$('#' + iframeName).remove();

								if (op.type == 'script')
									$.globalEval(resposta);

								op.success.call(form, resposta);
								
								// limpa o formulário
								var form_id = $(form).attr('id');								
								document.getElementById(form_id).reset();

							}, 500);
						});

						return true;

					}else{

						op.success.call(form);

					}

				}else
					op.error.call(form, camposErrados, op.callback);
					return false;
			});
		});
	}
});
