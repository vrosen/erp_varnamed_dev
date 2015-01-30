<?php header ("Content-Type:text/xml"); ?>
<?php echo '<?xml version="1.0" ?>'.PHP_EOL; ?>

<Document xmlns="urn:iso:std:iso:20022:tech:xsd:pain.008.001.02">
    <CstmrDrctDbtInitn>
        
        <GrpHdr>
            <MsgId><?php echo $MsgId; ?></MsgId><!-- OK -->
            <CreDtTm><?php echo $CreDtTm; ?></CreDtTm><!-- OK -->
            <NbOfTxs><?php  echo $numoftaxes; ?></NbOfTxs><!-- OK -->
            <CtrlSum><?php echo $cntrsum; ?></CtrlSum><!-- OK -->
            <InitgPty>
                <Nm><?php echo $Nm.'.BV'; ?></Nm><!-- OK -->
            </InitgPty>
        </GrpHdr>
       
        
        <PmtInf>
            <!-- COUNT TRANSACTIONS FUNCTION -->
            <PmtInfId>D20140110-6922202138-PID-00001</PmtInfId><?php $PmtInfId; ?>
            <PmtMtd><?php echo $PmtMtd; ?></PmtMtd><!-- OK -->
            <BtchBookg><?php echo $BtchBookg; ?></BtchBookg><!-- OK -->
            
            <NbOfTxs><?php echo $numoftaxes; ?></NbOfTxs><!-- OK -->
            <CtrlSum><?php echo $cntrsum; ?></CtrlSum><!-- OK -->
            <PmtTpInf>
                <SvcLvl>
                    <Cd><?php echo $CD; ?></Cd><!-- OK -->
                </SvcLvl>
                <LclInstrm>
                    <Cd><?php echo $Cd_DBT; ?></Cd><!-- OK -->
                </LclInstrm>
                <SeqTp><?php echo $SeqTp; ?></SeqTp><!-- OK -->
            </PmtTpInf>
            
            <ReqdColltnDt>2014-01-17</ReqdColltnDt><?php $ReqdColltnDt; ?>
            <Cdtr>
                <Nm><?php echo $Nm.'.BV'; ?></Nm><!-- OK -->
            </Cdtr>
            <CdtrAcct>
                <Id>
                    <IBAN><?php echo $IBAN_DBT; ?></IBAN><!-- OK -->
                </Id>
            </CdtrAcct>
            <CdtrAgt>
                <FinInstnId>
                    <BIC><?php echo $BIC_DBT; ?></BIC><!-- OK -->
                </FinInstnId>
            </CdtrAgt>
           
            
            <?php foreach ($all_details as $detail): ?>
                <?php $sec_details = unserialize($detail->bank_details); ?>
                  <?php $third_details = unserialize($detail->company_details); ?>
            
            <DrctDbtTxInf><!-- here starts the loop!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! -->
                <PmtId>
                    <EndToEndId>D20140110-6922202138-57548069349081</EndToEndId><?php $EndToEndId; ?><!-- LOOP -->
                </PmtId>
                <InstdAmt Ccy="EUR"><?php echo $cntrsum; ?></InstdAmt>
                <DrctDbtTx>
                    <MndtRltdInf>
                        <MndtId><?php echo $MndtId; ?></MndtId>
                        <DtOfSgntr><?php echo $DtOfSgntr; ?></DtOfSgntr>
                        <AmdmntInd>false</AmdmntInd><?php $AmdmntInd; ?>
                    </MndtRltdInf>
                    
                    <CdtrSchmeId>
                        <Id>
                            <PrvtId>
                                <Othr>
                                    <Id><?php echo $Id_CDT; ?></Id>
                                    <SchmeNm>
                                        <Prtry><?php echo $CD; ?></Prtry>
                                    </SchmeNm>
                                </Othr>
                            </PrvtId>
                            
                        </Id>
                    </CdtrSchmeId>
                </DrctDbtTx>
                <DbtrAgt>
                    <FinInstnId>
                        <BIC><?php echo $sec_details['BIC']; ?></BIC><!-- LOOP -->
                    </FinInstnId>
                </DbtrAgt>
                <Dbtr>
                    <Nm><?php echo $third_details['firstname'].$third_details['lastname']; ?></Nm><!-- LOOP -->
                </Dbtr>
                <DbtrAcct>
                    <Id>
                        <IBAN><?php echo $sec_details['IBAN']; ?></IBAN><!-- LOOP -->
                    </Id>
                </DbtrAcct>
                <Purp>
                    <Cd><?php echo $Cd_CDT; ?></Cd>
                </Purp>
                <RmtInf>
                    <Strd>
                        <CdtrRefInf>
                            <Tp>
                                <CdOrPrtry>
                                    <Cd><?php echo $CdOrPrtry_Cd; ?></Cd>
                                </CdOrPrtry>
                                <Issr><?php echo $Issr; ?></Issr>
                            </Tp>
                            <Ref>invoice<?php echo $detail->invoice_number; ?></Ref><?php $Ref; ?><!-- LOOP -->
                        </CdtrRefInf>
                    </Strd>
                </RmtInf>
            </DrctDbtTxInf>
            <!-- here stops the loop!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! -->
            <?php endforeach; ?>

        </PmtInf>
        
        
        
        
    </CstmrDrctDbtInitn>
</Document>

<?php

