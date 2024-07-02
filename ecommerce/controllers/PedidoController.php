<?php
require_once 'ecommerce/models/Pedido.php';
// Incluir la clase PHPMailer
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

// Requerir el archivo autoload.php de PHPMailer
require 'ecommerce/helpers/PHPMailer/Exception.php';
require 'ecommerce/helpers/PHPMailer/PHPMailer.php';
require 'ecommerce/helpers/PHPMailer/SMTP.php';

class PedidoController
{
	public function add()
	{
		if (isset($_SESSION['identity'])) {
			$usuario_id = $_SESSION['identity']->id;
			$municipio = isset($_POST['municipio']) ? $_POST['municipio'] : false;
			$localidad = isset($_POST['localidad']) ? $_POST['localidad'] : false;
			$direccion = isset($_POST['direccion']) ? $_POST['direccion'] : false;
			$referencia = isset($_POST['referencia']) ? $_POST['referencia'] : false;
			$telefono = isset($_POST['telefono']) ? $_POST['telefono'] : false;

			// Mensajes de depuración
			error_log("Debug - Municipio: $municipio, Localidad: $localidad, Dirección: $direccion");

			$stats = Utils::statsCarrito();
			$coste = isset($stats['total']) ? $stats['total'] : 0;

			if ($municipio && $localidad && $direccion) {
				$pedido = new Pedido();
				$pedido->setUsuario_id($usuario_id);
				$pedido->setMunicipio($municipio);
				$pedido->setLocalidad($localidad);
				$pedido->setDireccion($direccion);
				$pedido->setReferencia($referencia);
				$pedido->setTelefono($telefono);
				$pedido->setCoste($coste);

				$insert = $pedido->save();

				if ($insert) {
					$insert_linea = $pedido->save_linea();
					if ($insert_linea) {
						foreach ($_SESSION['carrito'] as $indice => $elemento) {
							require_once 'ecommerce/models/Producto.php';
							$pro = $elemento['producto'];
							$id = $pro->id;
							$unidades = $elemento['unidades'];

							$producto = new Producto();
							$producto->setId($id);
							$details_producto = $producto->getOne();
							if ($details_producto && isset($details_producto->stock)) {
								$newStock = $details_producto->stock - $unidades;
								$updateStock = false;
								if ($newStock > -1) {
									$updateStock = $producto->updateStock($id, $newStock);
								}
								if ($updateStock) {
									//Limpiar el carrito si es exitoso
									unset($_SESSION['carrito']);
									$_SESSION['pedido'] = 'complete';
								} else {
									$_SESSION['pedido'] = 'failed';
									break; // Salir del bucle si falla una actualización de stock
								}
							} else {
								$_SESSION['pedido'] = 'failed';
								break; // Salir del bucle si no se puede obtener el producto
							}
						}
					} else {
						$_SESSION['pedido'] = 'failed';
					}
				} else {
					$_SESSION['pedido'] = 'failed';
				}
			} else {
				$_SESSION['pedido'] = 'failed';
			}
			header('Location:' . base_url . 'pedido/confirmado');
		} else {
			header('Location:' . base_url);			
		}
	}


	public function confirmado()
	{
		if (isset($_SESSION['identity'])) {
			$identity = $_SESSION['identity'];
			$pedido = new Pedido();
			$pedido->setUsuario_id($identity->id);
			$pedido = $pedido->getPedidoByUser();
			$pedido_productos = new Pedido();
			$pedido_productos->setId($pedido->id);
			$productos = $pedido_productos->getProductosByPedido();
			require_once 'ecommerce/views/pedido/confirmado.php';
		}
	}
	public function hacer()
	{
		require_once 'ecommerce/views/pedido/hacer.php';
	}
	public function mis_pedidos()
	{
		$usuario_id = $_SESSION['identity']->id; // para versiones de php 5 en adelante, para acceder con flecha
		Utils::isIdentity();
		$pedido = new Pedido();

		// Sacar los pedidos del usuario
		$pedido->setUsuario_id($usuario_id);
		$pedidos = $pedido->getPedidosByUser();
		require_once 'ecommerce/views/pedido/mis_pedidos.php';
	}
	public function gestion()
	{
		Utils::isAdmin();
		$gestion = true;

		$pedido = new Pedido();
		$pedidos = $pedido->getPedidos();
		require_once 'ecommerce/views/pedido/mis_pedidos.php';
	}
	public function detalle()
	{
		Utils::isIdentity();
		if (isset($_GET['id'])) {
			$id = $_GET['id'];
			//Sacar pedido
			$pedido = new Pedido();
			$pedido->setId($id);
			$pedido = $pedido->getPedido();
			//Sacar productos
			$pedido_productos = new Pedido();
			$pedido_productos->setId($id);
			$productos = $pedido_productos->getProductosByPedido();
			require_once 'ecommerce/views/pedido/detalle.php';
		} else {
			header('Location:' . base_url . 'pedido/mis_pedidos.php');
		}
	}
	public function estado()
	{
		Utils::isAdmin();
		if (isset($_POST) && isset($_POST['pedido_id']) && isset($_POST['estado'])) {
			$id = $_POST['pedido_id'];
			$pedido = new Pedido();
			$pedido->setId($id);
			$pedido->setEstado($_POST['estado']);
			$pedido->update();

			if (is_object($pedido) && $pedido->getEstado()) {
				$_SESSION['PedidoControllerMessageSuccess'] = 'Se cambió el estado de manera exitosa a *' . Utils::showStatus($pedido->getEstado()) . '*.';
			} else {
				$_SESSION['PedidoControllerMessageError'] = 'Ocurrió un error al actualizar el estado.';
			}
			header('Location:' . base_url . 'pedido/detalle&id=' . $id);
		} else {
			header('Location:' . base_url);
		}
	}

	public function pagoCompletado()
	{
		if (isset($_GET['paymentID']) && isset($_GET['pedido_id'])) {
			$paymentID = $_GET['paymentID'];
			$pedidoId = $_GET['pedido_id'];

			// Verificar el paymentID con PayPal
			$paypalClientID = 'AT_hnmio2IdJthKN5CO0BbSx3DwbT5nkQCLS2SSKtiRZtYF7ZcvjYu4yS-RE9gsGpiR5XRWVmljsaPyE';
			$paypalSecret = 'ELx48JjzKGGccL-ccrQeEo9bvosGVXYh3Ry6RBStlaMjrgDl2xTUZWVwLFvNNfnqrZgoeF0HF_GTSDQ_';

			$token = $this->getPayPalToken($paypalClientID, $paypalSecret);
			if ($token) {
				$paymentValid = $this->verifyPaymentID($token, $paymentID);
				if ($paymentValid) {
					$pedido = new Pedido();
					$pedido->setId($pedidoId);
					$pedido->setEstado("preparation");
					$pedido->update();
					$_SESSION['pago'] = 'APPROVED';
					//Enviar email
					//Se usa identity para acceder al correo del usuario
					$identity = $_SESSION['identity'];
					$nombre_usuario = $identity->nombre . ' ' . $identity->apellidos;
					// Crear una instancia de PHPMailer
					$mail = new PHPMailer(true); // Pasar true habilita las excepciones					
					try {
						//Server settings
						$mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
						$mail->isSMTP();                                            //Send using SMTP
						$mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
						$mail->SMTPAuth   = true;                                   //Enable SMTP authentication
						$mail->Username   = 'trujilloingridgabriela@gmail.com';                     //SMTP username
						$mail->Password   = 'eorgyqcnxeakpzbg';                               //SMTP password
						$mail->SMTPSecure = 'tls';            //Enable implicit TLS encryption
						$mail->Port       = 587;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

						// Configurar el remitente y el destinatario
						$mail->setFrom('trujilloingridgabriela@gmail.com', 'Sweets');
						$mail->addAddress($identity->email, $nombre_usuario);
						$template_email_url = __DIR__ . "/email.php";

						// Leer el contenido del archivo HTML
						$file = fopen($template_email_url, "r");
						$str = fread($file, filesize($template_email_url));
						$str = trim($str);
						fclose($file);

						//Agregar variables que seran accesibles en el archivo html										
						$pedido = new Pedido();
						$pedido->setUsuario_id($identity->id);
						$pedido = $pedido->getPedidoByUser();
						$pedido_productos = new Pedido();
						$pedido_productos->setId($pedido->id);

						$productos = $pedido_productos->getProductosByPedido();
						//Hace posible el acceso de la variables en el template_email
						ob_start();
						include($template_email_url);
						$str = ob_get_clean();


						// Contenido del correo electrónico
						$mail->isHTML(true); // Habilitar el formato HTML
						$mail->Subject = 'Confirmación de pedido';
						$mail->Body = $str;
						$mail->AltBody = strip_tags($str);                    // Cuerpo alternativo en texto plano

						// Configuración del conjunto de caracteres a UTF-8
						$mail->CharSet = 'UTF-8';

						// Enviar el correo electrónico
						$mail->send();
						echo 'Correo electrónico enviado con éxito';
					} catch (Exception $e) {
						echo 'Error al enviar el correo electrónico: ' . $mail->ErrorInfo;
					}
					header('Location:' . base_url . 'pedido/detalle&id=' . $pedidoId . "&paymentID=" . $paymentID);
				} else {
					require_once 'ecommerce/views/pedido/error_pago.php';
				}
			} else {
				require_once 'ecommerce/views/pedido/error_pago.php';
			}
		} else {
			header('Location:' . base_url);
		}
	}

	private function getPayPalToken($clientID, $secret)
	{
		$url = "https://api-m.sandbox.paypal.com/v1/oauth2/token";
		$headers = [
			"Content-Type: application/x-www-form-urlencoded",
		];
		$postFields = "grant_type=client_credentials";

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_HEADER, false);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_USERPWD, $clientID . ":" . $secret);
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $postFields);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

		$response = curl_exec($ch);
		if (empty($response)) {
			curl_close($ch);
			return null;
		} else {
			$jsonData = json_decode($response);
			curl_close($ch);
			return $jsonData->access_token;
		}
	}

	private function verifyPaymentID($token, $paymentID)
	{
		$url = "https://api-m.sandbox.paypal.com/v2/checkout/orders/" . $paymentID;
		$headers = [
			"Content-Type: application/json",
			"Authorization: Bearer " . $token,
		];

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_HEADER, false);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

		$response = curl_exec($ch);
		if (empty($response)) {
			curl_close($ch);
			return false;
		} else {
			$paymentData = json_decode($response);
			curl_close($ch);
			return $paymentData->status == "APPROVED";
		}
	}
}
