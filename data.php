<?php
define('INCLUDE_CHECK', true);
require 'connect.php';
require 'functions.php';
session_name('esnBCNLogin');
session_set_cookie_params(1 * 7 * 24 * 60 * 60);
session_start();


if ($_POST['submit'] == "Update Information")
{
    $err = array();

    if (!is_numeric($_POST['phone']))
    {
        $err[] = "Please put a valid telephone number, 
                            forget about + and put 00 followed by the Country Code and your number without spaces ;)";
    }

    if (!$_POST['id'] || !$_POST['esncard'] || !$_POST['name'] || !$_POST['lastname'] ||
            !$_POST['gender'] || !$_POST['phone'] || !$_POST['uni'] || !$_POST['nac'] || !$_POST['shirt'])
        $err[] = 'All the fields must be filled in!';

    if (!$_POST['condiciones'])
    {
        $err[] = "You must accept the conditions if you want to get your spot in the trip";
    }
    
    $sql = "SELECT valido
            FROM users
            WHERE email='{$_SESSION['email']}'";
            
    $row = mysql_fetch_assoc(mysql_query($sql));
    
    if ($row['valido'])
    {
        $err[] = "Your data have been validated and you get your place, so you can not modify your data";
    }

    if (!count($err))
    {
        $_POST['id'] = mysql_real_escape_string($_POST['id']);
        $_POST['esncard'] = mysql_real_escape_string($_POST['esncard']);
        $_POST['name'] = mysql_real_escape_string($_POST['name']);
        $_SESSION['name'] = $_POST['name'];
        $_POST['lastname'] = mysql_real_escape_string($_POST['lastname']);
        $_POST['gender'] = mysql_real_escape_string($_POST['gender']);
        $_POST['phone'] = mysql_real_escape_string($_POST['phone']);
        $_POST['uni'] = mysql_real_escape_string($_POST['uni']);
        $_POST['nat'] = mysql_real_escape_string($_POST['nat']);
        $_POST['shirt'] = mysql_real_escape_string($_POST['shirt']);


        $sql = "UPDATE users SET id = '" . $_POST['id'] . "', 
                                                         esncard= '" . $_POST['esncard'] . "',
                                                         name = '" . $_POST['name'] . "', 
                                                         lastname = '" . $_POST['lastname'] . "', 
                                                         gender = '" . $_POST['gender'] . "',
                                                         phone = '" . $_POST['phone'] . "',
                                                         uni = '" . $_POST['uni'] . "',
                                                         nac = '" . $_POST['nac'] . "',
                                                         shirt = '" . $_POST['shirt'] . "'
                                            WHERE email='{$_SESSION['email']}'";
        mysql_query($sql);

        $_SESSION['msg']['reg-success'] = 'Now, we have got your data ;)
                                    Remember to upload your documents in order to complete the registration';
    }

    if (count($err))
    {
        $_SESSION['msg']['reg-err'] = implode('<br />', $err);
    }
    
    header("Location: data.php");
    exit;
    
}

include('panel.php');
if ($_SESSION['email']):
    ?>
    <div class="pageContent">
        <div id="main">

            <div class="container">

                <h1>Fill your data!</h1>

                <?php
                if ($_SESSION['msg']['reg-err'])
                {
                    echo '<div class="err"><p>' . $_SESSION['msg']['reg-err'] . '</p></div>';
                    unset($_SESSION['msg']['reg-err']);
                }

                if ($_SESSION['msg']['reg-success'])
                {
                    echo '<div class="success"><p>' . $_SESSION['msg']['reg-success'] . '</p></div>';
                    unset($_SESSION['msg']['reg-success']);
                }
                ?>

                    <?php
                    $row = mysql_fetch_assoc(
                            mysql_query("SELECT *
                                     FROM users 
                                     WHERE email='{$_SESSION['email']}'")
                    );
                    ?>

                <form method="post" class="clearfix" action="data.php">

                    <label>Email Address:</label>
                    <label> <?php echo $_SESSION['email']; ?> </label>
                    <br/><br/>
                    <label for="id">ID - Passport:</label>
                    <input type="text" name="id" id="id" value= "<? echo $row['id']; ?>" />
                    <br/><br/>
                    <label for="esncard">ESN Card:</label>
                    <input type="text" name="esncard" id="esncard" maxlength="10" value= "<? echo $row['esncard']; ?>" />
                    <br/><br/>
                    <label for="name">Name:</label>
                    <input type="text" name="name" id="name" value= "<? echo $_SESSION['name']; ?>" />
                    <br/><br/>
                    <label for="lastname">Last Name:</label>
                    <input type="text" name="lastname" id="lastname" value= "<? echo $row['lastname']; ?>" />
                    <br/><br/>
                    <label for="phone">Phone:</label>
                    <input type="text" name="phone" id="phone" value="<?
                if ($row['phone'])
                {
                    echo $row['phone'];
                }
                else
                {
                    echo "Insert your number phone";
                }
                ?>" />                   
                    <br/><br/>
                    <label for="gender">Gender:</label> 
                    <select id="gender" name="gender"> 
                        <option value="">-- select one --</option>	
                        <option value="man">Man</option> 
                        <option value="woman">Woman</option> 
                    </select>
    <? echo $row['gender']; ?>
                    <br/><br/>
                    <label for="uni">University:</label> 
                    <select id="uni" name="uni"> 
                        <option value="">-- select one --</option>	
                        <option value="UB">UB</option> 
                        <option value="UAB">UAB</option>
                        <option value="UPC">UPC</option>
                        <option value="UPF">UPF</option>
                        <option value="Others">Others</option>
                    </select>
    <? echo $row['uni']; ?>
                    <br/><br/>
                    <label for="nac">Nationality:</label>
                    <select id="nac" name="nac"> 
                        <option value="">--- select one ---</option>
                        <option value="">--- Commons ones ---</option>
                        <option value="andorran">Andorran</option>
                        <option value="argentinean">Argentinean</option>
                        <option value="austrian">Austrian</option>
                        <option value="belgian">Belgian</option>
                        <option value="british">British</option>
                        <option value="canadian">Canadian</option>
                        <option value="croatian">Croatian</option>
                        <option value="czech">Czech</option>
                        <option value="danish">Danish</option>
                        <option value="finnish">Finnish</option>
                        <option value="french">French</option>
                        <option value="german">German</option>
                        <option value="greek">Greek</option>
                        <option value="hungarian">Hungarian</option>
                        <option value="icelander">Icelander</option>
                        <option value="italian">Italian</option>
                        <option value="liechtensteiner">Liechtensteiner</option>
                        <option value="lithuanian">Lithuanian</option>
                        <option value="luxembourger">Luxembourger</option>
                        <option value="mexican">Mexican</option>
                        <option value="norwegian">Norwegian</option>
                        <option value="russian">Russian</option>
                        <option value="scottish">Scottish</option>
                        <option value="spanish">Spanish</option>
                        <option value="swedish">Swedish</option>
                        <option value="swiss">Swiss</option>
                        <option value="swiss">Swiss</option>
                        <option value="">--- More ---</option>   
                        <option value="afghan">Afghan</option>
                        <option value="albanian">Albanian</option>
                        <option value="algerian">Algerian</option>
                        <option value="american">American</option>
                        <option value="angolan">Angolan</option>
                        <option value="antiguans">Antiguans</option>
                        <option value="armenian">Armenian</option>
                        <option value="australian">Australian</option>
                        <option value="azerbaijani">Azerbaijani</option>
                        <option value="bahamian">Bahamian</option>
                        <option value="bahraini">Bahraini</option>
                        <option value="bangladeshi">Bangladeshi</option>
                        <option value="barbadian">Barbadian</option>
                        <option value="barbudans">Barbudans</option>
                        <option value="batswana">Batswana</option>
                        <option value="belarusian">Belarusian</option>
                        <option value="belizean">Belizean</option>
                        <option value="beninese">Beninese</option>
                        <option value="bhutanese">Bhutanese</option>
                        <option value="bolivian">Bolivian</option>
                        <option value="bosnian">Bosnian</option>
                        <option value="brazilian">Brazilian</option>
                        <option value="bruneian">Bruneian</option>
                        <option value="bulgarian">Bulgarian</option>
                        <option value="burkinabe">Burkinabe</option>
                        <option value="burmese">Burmese</option>
                        <option value="burundian">Burundian</option>
                        <option value="cambodian">Cambodian</option>
                        <option value="cameroonian">Cameroonian</option>
                        <option value="cape verdean">Cape Verdean</option>
                        <option value="central african">Central African</option>
                        <option value="chadian">Chadian</option>
                        <option value="chilean">Chilean</option>
                        <option value="chinese">Chinese</option>
                        <option value="colombian">Colombian</option>
                        <option value="comoran">Comoran</option>
                        <option value="congolese">Congolese</option>
                        <option value="costa rican">Costa Rican</option>
                        <option value="croatian">Croatian</option>
                        <option value="cuban">Cuban</option>
                        <option value="cypriot">Cypriot</option>
                        <option value="djibouti">Djibouti</option>
                        <option value="dominican">Dominican</option>
                        <option value="dutch">Dutch</option>
                        <option value="east timorese">East Timorese</option>
                        <option value="ecuadorean">Ecuadorean</option>
                        <option value="egyptian">Egyptian</option>
                        <option value="emirian">Emirian</option>
                        <option value="equatorial guinean">Equatorial Guinean</option>
                        <option value="eritrean">Eritrean</option>
                        <option value="estonian">Estonian</option>
                        <option value="ethiopian">Ethiopian</option>
                        <option value="fijian">Fijian</option>
                        <option value="filipino">Filipino</option>
                        <option value="gabonese">Gabonese</option>
                        <option value="gambian">Gambian</option>
                        <option value="georgian">Georgian</option>
                        <option value="ghanaian">Ghanaian</option>
                        <option value="grenadian">Grenadian</option>
                        <option value="guatemalan">Guatemalan</option>
                        <option value="guinea-bissauan">Guinea-Bissauan</option>
                        <option value="guinean">Guinean</option>
                        <option value="guyanese">Guyanese</option>
                        <option value="haitian">Haitian</option>
                        <option value="herzegovinian">Herzegovinian</option>
                        <option value="honduran">Honduran</option>
                        <option value="indian">Indian</option>
                        <option value="indonesian">Indonesian</option>
                        <option value="iranian">Iranian</option>
                        <option value="iraqi">Iraqi</option>
                        <option value="irish">Irish</option>
                        <option value="israeli">Israeli</option>
                        <option value="ivorian">Ivorian</option>
                        <option value="jamaican">Jamaican</option>
                        <option value="japanese">Japanese</option>
                        <option value="jordanian">Jordanian</option>
                        <option value="kazakhstani">Kazakhstani</option>
                        <option value="kenyan">Kenyan</option>
                        <option value="kittian and nevisian">Kittian and Nevisian</option>
                        <option value="kuwaiti">Kuwaiti</option>
                        <option value="kyrgyz">Kyrgyz</option>
                        <option value="laotian">Laotian</option>
                        <option value="latvian">Latvian</option>
                        <option value="lebanese">Lebanese</option>
                        <option value="liberian">Liberian</option>
                        <option value="libyan">Libyan</option>
                        <option value="macedonian">Macedonian</option>
                        <option value="malagasy">Malagasy</option>
                        <option value="malawian">Malawian</option>
                        <option value="malaysian">Malaysian</option>
                        <option value="maldivan">Maldivan</option>
                        <option value="malian">Malian</option>
                        <option value="maltese">Maltese</option>
                        <option value="marshallese">Marshallese</option>
                        <option value="mauritanian">Mauritanian</option>
                        <option value="mauritian">Mauritian</option>
                        <option value="micronesian">Micronesian</option>
                        <option value="moldovan">Moldovan</option>
                        <option value="monacan">Monacan</option>
                        <option value="mongolian">Mongolian</option>
                        <option value="moroccan">Moroccan</option>
                        <option value="mosotho">Mosotho</option>
                        <option value="motswana">Motswana</option>
                        <option value="mozambican">Mozambican</option>
                        <option value="namibian">Namibian</option>
                        <option value="nauruan">Nauruan</option>
                        <option value="nepalese">Nepalese</option>
                        <option value="new zealander">New Zealander</option>
                        <option value="ni-vanuatu">Ni-Vanuatu</option>
                        <option value="nicaraguan">Nicaraguan</option>
                        <option value="nigerien">Nigerien</option>
                        <option value="north korean">North Korean</option>
                        <option value="northern irish">Northern Irish</option>
                        <option value="omani">Omani</option>
                        <option value="pakistani">Pakistani</option>
                        <option value="palauan">Palauan</option>
                        <option value="panamanian">Panamanian</option>
                        <option value="papua new guinean">Papua New Guinean</option>
                        <option value="paraguayan">Paraguayan</option>
                        <option value="peruvian">Peruvian</option>
                        <option value="polish">Polish</option>
                        <option value="portuguese">Portuguese</option>
                        <option value="qatari">Qatari</option>
                        <option value="romanian">Romanian</option>
                        <option value="rwandan">Rwandan</option>
                        <option value="saint lucian">Saint Lucian</option>
                        <option value="salvadoran">Salvadoran</option>
                        <option value="samoan">Samoan</option>
                        <option value="san marinese">San Marinese</option>
                        <option value="sao tomean">Sao Tomean</option>
                        <option value="saudi">Saudi</option>      
                        <option value="senegalese">Senegalese</option>
                        <option value="serbian">Serbian</option>
                        <option value="seychellois">Seychellois</option>
                        <option value="sierra leonean">Sierra Leonean</option>
                        <option value="singaporean">Singaporean</option>
                        <option value="slovakian">Slovakian</option>
                        <option value="slovenian">Slovenian</option>
                        <option value="solomon islander">Solomon Islander</option>
                        <option value="somali">Somali</option>
                        <option value="south african">South African</option>
                        <option value="south korean">South Korean</option>
                        <option value="sri lankan">Sri Lankan</option>
                        <option value="sudanese">Sudanese</option>
                        <option value="surinamer">Surinamer</option>
                        <option value="swazi">Swazi</option>
                        <option value="syrian">Syrian</option>
                        <option value="taiwanese">Taiwanese</option>
                        <option value="tajik">Tajik</option>
                        <option value="tanzanian">Tanzanian</option>
                        <option value="thai">Thai</option>
                        <option value="togolese">Togolese</option>
                        <option value="tongan">Tongan</option>
                        <option value="trinidadian or tobagonian">Trinidadian or Tobagonian</option>
                        <option value="tunisian">Tunisian</option>
                        <option value="turkish">Turkish</option>
                        <option value="tuvaluan">Tuvaluan</option>
                        <option value="ugandan">Ugandan</option>
                        <option value="ukrainian">Ukrainian</option>
                        <option value="uruguayan">Uruguayan</option>
                        <option value="uzbekistani">Uzbekistani</option>
                        <option value="venezuelan">Venezuelan</option>
                        <option value="vietnamese">Vietnamese</option>
                        <option value="welsh">Welsh</option>
                        <option value="yemenite">Yemenite</option>
                        <option value="zambian">Zambian</option>
                        <option value="zimbabwean">Zimbabwean</option>
                    </select>
    <? echo $row['nac']; ?>
                    <br/><br/>

                    <label for="shirt">Shirt:</label> 
                    <select id="shirt" name="shirt"> 
                        <option value="">-- select one --</option>
                        <option value="XS">XS</option>
                        <option value="S">S</option> 
                        <option value="M">M</option>
                        <option value="L">L</option>
                        <option value="XL">XL</option>
                    </select>
    <? echo $row['shirt']; ?>
                    <br/><br/>

                    <label for="condiciones"><a href="javascript: window.open('terms.php', 'window_name', 'width = 850, height = 600');
                                                ">Terms & Conditions:</a></label>
                    <input type="checkbox" name="condiciones" id="condiciones" value= "1" />
                    <br/><br/>

                    <div class="clear"></div>
                    <input type="submit" name="submit" value="Update Information" />
                </form>

            </div>

        <?php include('foot.php'); ?>
        </div>
        <?php
    endif;
    ?>
</div>
</body>
</html>
