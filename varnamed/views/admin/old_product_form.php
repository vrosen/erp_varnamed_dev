<?php include('header.php'); ?>
<link rel="stylesheet" href="<?php echo base_url('assets/old_product/style.css'); ?>" type="text/css">
<link rel="stylesheet" href="<?php echo base_url('assets/old_product/medsorgstyle.css'); ?>" type="text/css">






<table id="p-ca" border="0" cellpadding="0" cellspacing="0">
	<tbody>

	<tr id="p_carow2"> 
		<td id="p-column1" valign="top"> 


		
			
				<input name="opdracht" value="" type="hidden">
				<input name="nieuw" value="n" type="hidden">
				<input name="artikel.nr" value="27247" type="hidden">
				<input name="menuid" value="9048" type="hidden">
				<input name="curname" value="editartikelinfo" type="hidden">
		
				<table border="0">
					<tbody><tr class="rcolor">
						<td><b>General</b></td>
						<td></td>
						<td></td>
					</tr>
					<tr>
						<td>Article number (max 12 Z.)</td>
						<td></td>
						<td>
							<input id="naam" name="artikel.code" value="<?php echo $old_product->code; ?>">
						</td>
					</tr>
					<tr>
						<td>Artikelname (max 60 Z.)</td>
						<td></td>
						<td><input size="60" maxlength="60" name="artikel.definitie" value="<?php echo $old_product->name; ?>"  type="text"></td>
					</tr>
					<tr>
						<td>Rechnungbeschreibung (max 60 Z.)</td>
						<td><img src="<?php echo base_url('assets/old_product/vlag_klein_nl.png'); ?>" alt="Flagge NEDERLAND"></td>
                                                <td><input size="60" maxlength="60" name="artikeltekst.factuuromschr" value="<?php echo str_replace('MEDSORG ', $current_shop, $old_product->description); ?>" onchange="hasChanged()" onkeypress="checkEnter('artikel',event)" type="text"></td>
					</tr>
					<tr>
						<td valign="top">Description (für Angebote)</td>
						<td style="vertical-align:top;"><img src="<?php echo base_url('assets/old_product/vlag_klein_nl.png'); ?>" alt="Flagge NEDERLAND"></td>
						<td><textarea name="artikeltekst.definitie" cols="45" rows="5" onchange="hasChanged()" onkeypress="checkEnter('artikel',event)"><?php echo $old_product->description; ?></textarea></td>
					</tr>

						<tr>
							<td>Dienstleistung</td>
							<td></td>
							<td><input name="artikel.dienst" value=".T." type="checkbox"></td>
						</tr>
						<tr>
							<td>Versendung durch supplier</td>
							<td></td>
							<td><input name="artikel.verzending_leverancier" value=".T." type="checkbox"></td>
						</tr>
						<tr>
							<td>Zeigen in Webshop</td>
							<td><img src="<?php echo base_url('assets/old_product/vlag_klein_nl.png'); ?>" alt="Flagge NEDERLAND"></td>
							<td><input name="artikeltekst.visible" value=".T." type="checkbox"></td>
						</tr>
						<tr>
							<td>Systemartikel</td>
							<td></td>
							<td><input name="artikel.systeem" value=".F." type="hidden">
								<input name="artikel.systeem" value=".T." type="checkbox"></td>
						</tr>
						<tr>
							<td>Sample</td>
							<td></td>
							<td><input name="artikel.monster" value=".F." type="hidden">
								<input name="artikel.monster" value=".T." type="checkbox"></td>
						</tr>
						<tr>
							<td>Gelöscht</td>
							<td><input name="artikel.delrecord" value=".T." type="checkbox"></td>
						</tr>
						<tr>
							<td valign="top">Foto</td>
							<td></td>
							<td><img src="<?php echo base_url('assets/old_product/'.$old_product->FOTO); ?>" alt="Foto">
								<p>
									<input name="artikel.foto" value="<?php echo $old_product->FOTO; ?>" onchange="hasChanged()" onkeypress="checkEnter('artikel',event)" type="text">
									
								</p>
							</td>
						</tr>

						<tr class="rcolor">
							<td><b>Lieferanten Info</b></td>
							<td></td>
							<td>&nbsp;</td>
						</tr>
           
                                                
                                                <!--  SUPPLIER -->
                                                <?php if(!empty($suppliers)): ?>
                                                <?php foreach ($suppliers as $suplier): ?>
						<tr>
							<td><b>supplier</b></td>
							<td></td>
							<td><a href="<?php echo $suplier->web; ?>"><b><?php echo $suplier->company; ?></b></a></td>
						</tr>
						<tr>
							<td>Article number supplier (max 12 Z.)</td>
							<td></td>
							<td><input size="12" maxlength="12" name="relartikelleverancier.leverancierartikelcode" onchange="" onkeypress="checkEnter('artikel',event)" type="text">
							</td>
						</tr>
						<tr>
							<td>Mindestabnahme</td>
							<td></td>
							<td><table cellpadding="0" cellspacing="0">
								<tbody><tr>
									<td><input size="10" maxlength="6" name="relartikelleverancier.nminaantalveperink" value="<?php echo $suplier->NMINAANTAL; ?>" onchange="" onkeypress="checkEnter('artikel',event)" type="text"></td>
									<td>&nbsp;</td>
									<td>(Falls zutreffend Number Versandkartons auf Palette oder Container, sonst 1)</td>
								</tr>
							</tbody></table></td>
						</tr>
						<tr>
							<td>Lieferzeit (days)</td>
							<td></td>
							<td><input size="10" maxlength="6" name="relartikelleverancier.levertijd" value="<?php echo $suplier->LEVERTIJD; ?>" onchange="hasChanged()" onkeypress="checkEnter('artikel',event)" type="text"></td>
						</tr>
						<tr>
							<td>Einkaufspreis</td>
							<td></td>
							<td>EUR <input size="10" maxlength="10" name="relartikelleverancier.inkoopprijs" value="<?php echo $suplier->INKOOPPRIJ; ?>" onchange="hasChanged()" onkeypress="checkEnterBedrag('artikel',event,this)" onblur="BedragOpmaken(this)" type="text">
								pro
                                                       <?php
                                                       $eenhinkprijs = array(
                                                           
                                                           0    =>  'select...',
                                                           1    =>  'Einkaufsverpackung',
                                                           2    =>  '####',
                                                           3    =>  '#### 2)',
                                                           4    =>  'Number',
                                                       );
                                                       echo form_dropdown('',$eenhinkprijs,$suplier->EENHINKPRI);     
                                                       ?>         

								<input size="10" maxlength="6" id="aantal-5564" name="relartikelleverancier.npereenhinkprijs" value="<?php echo $suplier->NPEREENHIN; ?>" onchange="hasChanged()" disabled="disabled" type="text">
								St. </td>
						</tr>
						<tr>
							<td>Transportkosten </td>
							<td></td>
                                                        <td><input size="10" maxlength="10" name="relartikelleverancier.transportkperc" value="<?php echo $suplier->TRANSPORTK; ?>" onchange="hasChanged()" onkeypress="checkEnterBedrag('artikel',event,this)" type="text">
								(% vom Einkaufspreis) </td>
						</tr>
						<tr>
							<td valign="top">Verpackungsgröße (lxbxh mm)</td>
							<td></td>
                                                        <td><input size="20" name="relartikelleverancier.verpakkingsafmeting" onchange="hasChanged()" value="<?php echo $suplier->VERPAKKING; ?>" type="text"></td>
						</tr>
						<tr>
							<td valign="top">Remarks (Mindestbestellwert, <br>
								Frachtfreigrenze, u.s.w.)</td>
							<td></td>
							<td>
								<textarea name="relartikelleverancier.artikelopmerkingen" cols="45" rows="5"><?php echo $suplier->ARTIKELOPM; ?></textarea>
							</td>
						</tr>


                                                <?php endforeach; ?>
                                                 <?php endif; ?>
                                                <!--  SUPPLIER -->
                                                
						
						

						<tr>
							<td>&nbsp;</td>
							<td></td>
							<td></td>
						</tr>
						
						<tr class="rcolor">
							<td><b>Preise</b></td>
							<td></td>
							<td>&nbsp;</td>
						</tr>
						
						<tr>
							<td>DEP (Durchschnittspreis)</td>
							<td></td>
                                                        <td>EUR <?php if(!empty($suplier->INKOOPPRIJ)) echo $suplier->INKOOPPRIJ; ?></td>
						</tr>
						<tr>
							<td>DEP, Korrektur</td>
							<td></td>
                                                        <td>EUR <input size="10" maxlength="10" name="artikel.gipkorrektur" value="<?php echo $old_product->GIPKORREKT; ?>" type="text"></td>
						</tr>
						
						
						<tr>
							<td>EK (warehouse price ####)</td>
							<td></td>
							<td>EUR <input size="10" maxlength="10" name="artikel.warehouse" value="<?php echo $old_product->WAREHOUSE; ?>"  type="text"></td>
						</tr>
						
						<tr>
							<td>VK (#### Verkaufspreis)</td>
							<td><span style="vertical-align:top;"><img src="<?php echo base_url('assets/old_product/vlag_klein_nl.png'); ?>" alt="Flagge NEDERLAND"></span></td>
							<td><input name="artikeltekst.currency" value="EUR" type="hidden">EUR <input size="10" maxlength="10" name="artikeltekst.adviesprijs" value="<?php echo $old_product->ADVIESPRIJ; ?>" onchange="hasChanged()" onkeypress="checkEnterBedrag('artikel',event,this)" onblur="BedragOpmaken(this)" type="text"></td>
						</tr>
						
						<tr>
							<td>VAT</td>
							<td><img src="<?php echo base_url('assets/old_product/vlag_klein_nl.png'); ?>" alt="Flagge NEDERLAND"></td>
                                                        <?php $BTWCODE = array(5=>'20%',3=>'5,50%',1=>'0%',null=>'none'); ?>
                                                        <td><?php echo $BTWCODE[$old_product->BTWCODE]; ?></td>
						</tr>
						
						<tr>
							<td>Abweichende dispatch costs</td>
							<td><img src="<?php echo base_url('assets/old_product/vlag_klein_nl.png'); ?>" alt="Flagge NEDERLAND"></td>
                                                        <td><input size="10" maxlength="10" name="artikeltekst.afwijkendeverzendkosten" value="<?php echo $old_product->AFWIJKENDE; ?>" type="text"></td>
						</tr>

			
						<tr>
							<td>&nbsp;</td>
							<td></td>
							<td></td>
						</tr>
						<tr class="rcolor">
							<td><b>Packaging</b></td>
							<td></td>
							<td>&nbsp;</td>
						</tr>
						<tr><td colspan="3"><i>Hier nur Fehler korrigieren! Wenn die Packaging ändert, immer ein neuer Artikel eingeben.	</i></td></tr>
						<tr>
							<td>Number Unterverpackungen in ####</td>
							<td></td>
							<td nowrap="nowrap"><input size="10" maxlength="4" name="artikel.aantal1" value="<?php echo $old_product->AANTAL1; ?>" type="text"></td>
						</tr>
						<tr>
							<td>Number Kleinstverpackungen in Unterverpackung</td>
							<td></td>
							<td><input size="10" maxlength="4" name="artikel.aantal2" value="<?php echo $old_product->AANTAL2; ?>" type="text">
								(Falls nicht zutreffend, 1)</td>
						</tr>
						<tr>
							<td>Artikelzahl Kleinstverpackung</td>
							<td></td>
							<td><input size="10" maxlength="4" name="artikel.aantal3" value="<?php echo $old_product->AANTAL3; ?>" type="text"></td>
						</tr>
						<tr>
							<td>####</td>
							<td></td>
							<td><input name="artikel.ve" value="<?php echo $old_product->VE; ?>" checked="checked" type="radio">
								####
								<input name="artikel.ve" value="<?php echo $old_product->VE; ?>" type="radio">
								Unterverpackung</td>
						</tr>
						<tr>
							<td>Packaging <br>(z.B. 10 x 1 oder 1 Box à 100 Pcs.. )</td>
							<td></td>
							<td><input size="20" maxlength="20" name="artikel.verpakking" value="<?php echo $old_product->VERPAKKING; ?>"  type="text"> (input in English)</td>
						</tr>
			
			
						<tr>
							<td>&nbsp;</td>
							<td></td>
							<td></td>
						</tr>
						<tr class="rcolor">
							<td><b>Stock</b></td>
							<td></td>
							<td>&nbsp;</td>
						</tr>
						<tr>
							<td>Aktueller Stock (Verkaufsverpackungen)</td>
							<td></td>
							<td>0 (Available Stock: 0, Reserved: 0)</td>
						</tr>
						<tr>
							<td>Mindestbestand Artikel</td>
							<td></td>
							<td>
                                                            <input name="artikel.voorraadartikel" value="<?php echo $old_product->VOORRAADAR; ?>" type="checkbox"></td>
						</tr>
						<tr>
							<td>Minimum Stock (berechnet)</td>
							<td></td>
							<td>0</td>
						</tr>
						<tr>
							<td>Minimum Stock Korrektur</td>
							<td></td>
							<td>
                                                            <input size="10" maxlength="6" name="artikel.minaantal" value="<?php echo $old_product->MINAANTAL; ?>"  type="text">
							</td>
						</tr>
			
						<tr>
							<td>GEWICHT</td>
							<td></td>
							<td><input size="10" maxlength="6" name="artikel.gewicht" value="<?php echo $old_product->GEWICHT; ?>"  type="text"></td>
						</tr>
						<tr>
							<td>&nbsp;</td>
							<td></td>
							<td></td>
						</tr>
						<tr class="rcolor">
							<td><b>Wichtige Features</b></td>
							<td></td>
							<td>input in English</td>
						</tr>
						<tr><td align="left">Maat</td>
<td align="left"></td>
<td align="left"><input name="artikel.col1" size="30" value="<?php echo $old_product->COL1; ?>" type="text"></td>
</tr><tr><td align="left">Kleur</td>
<td align="left"></td>
<td align="left"><input name="artikel.col2" size="30" value="<?php echo $old_product->COL2; ?>" type="text"></td>
</tr>
						<tr>
							<td>&nbsp;</td>
							<td></td>
							<td></td>
						</tr>
						<tr class="rcolor">
							<td><b>Weitere Info</b></td>
							<td></td>
							<td>&nbsp;</td>
						</tr>
						<tr>
							<td>PZN</td>
							<td></td>
							<td><input size="30" maxlength="30" name="artikel.pzn" value="<?php echo $old_product->PZN; ?>"  type="text"></td>
						</tr>
						<tr>
							<td>Quote gültig until</td>
							<td></td>
							<td><input size="30" maxlength="30" name="artikel.geldigtot" value="<?php    echo $old_product->GELDIGTOT; ?>" type="text"></td>
						</tr>
						<tr>
							<td>Quote Discount %</td>
							<td></td>
							<td><input size="30" maxlength="30" name="artikel.actiekorting" value="<?php    echo $old_product->ACTIEKORTI; ?>" type="text"></td>
						</tr>
		






					</tbody></table>

<?php include('footer.php'); ?>