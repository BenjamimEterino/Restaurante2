<?php include 'header.php'; ?>



    
        <div class="welcome-gallery small-12 columns">



            <div class="photo-section small-12 columns">
                <img class="homepage-main-photo" src="img/front.jpg" alt="slider imagem 1">
            </div>

            <div class="main-section-title small-10 columns">
                <div class="table">
                    <div class="table-cell">
                        <h1>Bem vindo ao Moza Food</h1>
                        <h2>A cozinha tradicional na Brasa</h2>

                    </div>
                </div>
                
            </div>

            <div class="photo-gradient">
                
            </div>

        </div>


    

      

    
        <div class="cardapio small-11 large-12 columns no-padding small-centered">
            <div class="global-page-container">
                <div class="cardapio-title small-12 columns no-padding">
                <h3>Cardapio</h3>
                <hr></hr>
                </div>
            </div>

            <div class="global-page-container">


                <div class="slider-cardapio">
                    <div class="slider-002 small-12 small-centered columns">

                      <?php

                        $server = 'localhost';
                        $user = 'root';
                        $password = '';
                        $db_name = 'restaurante';
                        $port = '8090';

                        $db_connect = new mysqli($server,$user,$password,$db_name,$port);
                        mysqli_set_charset($db_connect,"utf8");

                        if ($db_connect->connect_error) {
                            echo 'Falha: ' . $db_connect->connect_error;
                        } else {
                            //echo 'Conexão feita com sucesso' . '<br><br>';
                            $sql = "SELECT * FROM pratos WHERE destaque=1 ";
                            $result = $db_connect->query($sql);

                            if($result->num_rows>0){
                                while($row = $result->fetch_assoc()){ ?>

                                    <div class="cardapio-item-outer bounce-hover small-10 medium-4 columns"> 
                                    <div class="cardapio-item">
                                        <a href="prato.php?prato=<?php echo $row['codigo']; ?>">
                                            
                                            <div class="cardapio-item-image">
                                                <img src="img/cardapio/<?php echo $row['codigo']; ?>.jpg" alt="camarao"/>   
                                            </div>

                                            <div class="item-info">
                                                
                                            
                                                <div class="title"><?php echo $row['nome']; ?></div>
                                            </div>

                                            <div class="gradient-filter">
                                            </div>
                                            
                                        </a>
                                    </div>
                                </div>
                               <?php }
                            } else{
                                'Nao ha destaques';
                            }
                        }
                        ?>   

                    </div>
                </div>
            </div>
        </div>

        <div id="contact-us" class="contact-us small-11 large-12 columns no-padding small-centered">

            <div class="global-page-container">
                <div class="contact-us-title small-12 columns no-padding">
                <h3>Faça a sua reserva</h3>
                <hr></hr>
                </div>
                

                <div class="reservation-form small-12 columns no-padding">

                    <form action="index.php#contact-us" method="post">

                        <div class="form-part1 small-12 large-8 xlarge-7 columns no-padding">
                    
                            <input type="text" name="nome" class="field" placeholder="Nome completo" required/>
                            
                            <input type="email" name="email" class="field" placeholder="E-mail" required/>
                            
                            <textarea type="text" name="mensagem" class="field" placeholder="Mensagem"></textarea>


                        </div>

                        <div class="form-part2 small-12 large-3 xlarge-3 end columns no-padding">
                            <input type="text" name="telefone" class="field" placeholder="Telefone" required/>
                            
                            <input type="datetime-local" name="data" class="field" placeholder="Data e hora" required/>

                            <input type="text" name="num_pessoas" class="field" placeholder="Número de pessoas" required/>

                            <input type="submit" name="submit" value="Reservar"/>

                        </div>


                    </form>
                    <?php 
                    // Inserir Arquivos do PHPMailer
                    require 'phpmailer/Exception.php';
                    require 'phpmailer/PHPMailer.php';
                    require 'phpmailer/SMTP.php';

                    // Usar as classes sem o namespace
                    use PHPMailer\PHPMailer\PHPMailer;
                    use PHPMailer\PHPMailer\Exception;
                         

                        
                        function clean_input($input){
                            $input = trim($input);
                            $input = stripslashes($input);
                            $input = htmlspecialchars($input);
                            
                            return $input;
                        }
                    
                        
                        if($_SERVER['REQUEST_METHOD'] == 'POST') {
                           $nome = $_POST['nome'];
                           $email = $_POST['email'];
                           $mensagem = $_POST['mensagem'];
                           $telefone = $_POST['telefone'];
                           $data = $_POST['data'];
                           $numero = $_POST['num_pessoas'];

                            $nome = clean_input($nome);
                           $email = clean_input($email);
                           $mensagem = clean_input($mensagem);
                           $telefone = clean_input($telefone);
                           $data = clean_input($data);
                           $numero = clean_input($numero);


                           $texto_msg = 'E-mail enviado do sistema de reservas do site' . '<br><br>' .
                           'Nome: ' . $nome . '<br>' .
                           'E-mail: ' . $email . '<br>' .
                           'Numero de pessoas: ' . $numero . '<br>' .
                           'Telefone: ' . $telefone . '<br>' .
                           'Data: ' . $data . '<br>' .                           
                           'Mensagem: ' . $mensagem . '<br>';

                           // Criação do Objeto da Classe PHPMailer
                            $mail = new PHPMailer(true);
                            $mail->CharSet="UTF-8";

                           try {
                        
                        //Retire o comentário abaixo para soltar detalhes do envio 
                        // $mail->SMTPDebug = 2;                                
                        
                        // Usar SMTP para o envio
                        $mail->isSMTP();                                      

                        // Detalhes do servidor (No nosso exemplo é o Google)
                        $mail->Host = 'smtp.gmail.com';

                        // Permitir autenticação SMTP
                        $mail->SMTPAuth = true;                               

                        // Nome do usuário
                        $mail->Username = 'trabalhopw2021@gmail.com';        
                        // Senha do E-mail         
                        $mail->Password = 'helioalves2021';                           
                        // Tipo de protocolo de segurança
                        $mail->SMTPSecure = 'tls';   

                        // Porta de conexão com o servidor                        
                        $mail->Port = 587;

                        
                        // Garantir a autenticação com o Google
                        $mail->SMTPOptions = array(
                            'ssl' => array(
                                'verify_peer' => false,
                                'verify_peer_name' => false,
                                'allow_self_signed' => true
                            )
                        );

                        // Remetente
                        $mail->setFrom($email, $nome);
                        
                        // Destinatário
                        $mail->addAddress('trabalhopw2021@gmail.com', 'Benjamim');

                        // Conteúdo

                        // Define conteúdo como HTML
                        $mail->isHTML(true);                                  

                        // Assunto
                        $mail->Subject = 'Pedido de Reserva';
                        $mail->Body    = $texto_msg;
                        $mail->AltBody = $texto_msg;

                        // Enviar E-mail
                        $mail->send();
                        echo 'Mensagem enviada com sucesso';
                    } catch (Exception $e) {
                        echo 'A mensagem não foi enviada pelo seguinte motivo: ', $mail->ErrorInfo;
                    }
                            
                        }

                       
             
                   

                     


                    

                                        


                           
                         
                    ?>
                    
                </div>

                       
            </div>
        </div>



 <?php include 'footer.php'; ?>
