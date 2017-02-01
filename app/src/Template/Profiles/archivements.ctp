
<h2>
        
<!--<h3>-->
<!--        現在の称号：<?php-->
<!--        foreach ($now as $contact):-->
<!--        if($now){echo $contact->reward;}-->
<!--        endforeach;-->
<!--        ?>-->
<!--</h3>-->
<!--<p>-->
<!--    <?=$this->Form->postLink(__("称号解除"), ['action' => 'archivements', 0])?>-->
<!--</p>-->

<table>
    <tr>
        <th nowrap>投稿枚数</br><?php echo $pushCount?>枚</th>
        <th nowrap>コメントした</br><?php echo $commentsCount?>回</th>
        <th nowrap>いいねした</br><?php echo $favoritesCount?>回</th>
        <th nowrap>いいねされた</br><?php echo $popularCount?>回</th>
    </tr>
</table>

<?php
echo $this->Form->postLink(__("総合"), ['action' => 'archivements', 0],['class' => 'btn btn-default']);
echo $this->Form->postLink(__("投稿"), ['action' => 'archivements', 1],['class' => 'btn btn-default']);
echo $this->Form->postLink(__("コメント"), ['action' => 'archivements', 2],['class' => 'btn btn-default']);
echo $this->Form->postLink(__("いいね"), ['action' => 'archivements', 3],['class' => 'btn btn-default']);
echo $this->Form->postLink(__("人気"), ['action' => 'archivements', 4],['class' => 'btn btn-default']);
// echo $this->Form->postLink(__("その他"), ['action' => 'archivements', 5],['class' => 'btn btn-default']);
?>
</h2>

<table align="left" border="1"　>
    <thead>
        <tr>
            <th>目標</th>
            <th>達成度</th>
            <th>報酬</th>
            <!--<th>称号設定</th>-->
        </tr>
        
        <?php if($id==0){?>
            <tr>
                <td><?php
                    if($pushData==null){echo "投稿枚数";}
                    else{echo $pushData->goal;} 
                ?></td>
                <td><?php
                    if($pushData==null){echo "全目標達成";}
                    else if($pushCount>=$pushData->requirements){echo "目標達成";}
                    else{echo "目標未達成";}
                ?></td>
                <td><?php
                    if($pushData==null){echo "END";}
                    else if($pushCount>=$pushData->requirements){echo $pushData->reward;} 
                    else{echo "???";}
                ?></td>
            </tr>
            <tr>
                <td><?php 
                    if($commentsData==null){echo "コメント数";}
                    else{echo $commentsData->goal;} 
                ?></td>
                <td><?php 
                    if($commentsData==null){echo "全目標達成";}
                    else if($commentsCount>=$commentsData->requirements){echo "目標達成";} 
                    else{echo "目標未達成";}
                ?></td>
                <td><?php
                    if($commentsData==null){echo "END";}
                    else if($commentsCount>=$commentsData->requirements){echo $commentsData->reward;} 
                    else{echo "???";}
                ?></td>    
            </tr>
            <tr>
                <td><?php 
                    if($favoritesData==null){echo "いいねした回数";}
                    else{echo $favoritesData->goal;}
                ?></td>
                <td><?php
                    if($favoritesData==null){echo "全目標達成";}
                    else if($favoritesCount>=$favoritesData->requirements){echo "目標達成";} 
                    else{echo "目標未達成";}
                ?></td>
                <td><?php
                    if($favoritesData==null){echo "END";}
                    else if($favoritesCount>=$pushData->requirements){echo $favoritesData->reward;} 
                    else{echo "???";}
                ?></td>    
            </tr>
            <tr>
                <td><?php 
                    if($popularData==null){echo "いいねされた回数";}
                    else{echo $popularData->goal;} 
                ?></td>
                <td><?php 
                    if($popularData==null){echo "全目標達成";}
                    else if($popularCount>=$popularData->requirements){echo "目標達成";} 
                    else{echo "目標未達成";}
                ?></td>
                <td><?php
                    if($popularData==null){echo "END";}
                    else if($popularCount>=$popularData->requirements){echo $popularData->reward;} 
                    else{echo "???";}
                ?></td>    
            </tr>
        <?php } ?>
        
        <?php if($id!=0){?>
            <?php foreach ($archives as $contact): ?>
            <tr>
                <td><?php echo $contact->goal; ?></td>
            
                <td><?php 
                    if($counts>=$contact->requirements){echo "目標達成";} 
                    else{echo "目標未達成";}
                ?></td>
                <td><?php
                    if($counts>=$contact->requirements){echo $contact->reward;} 
                    else{echo "???";}
                ?></td>
                <!--<td><?php-->
                <!--    if($counts>=$contact->requirements){echo $this->Form->postLink(__("set"), ['action' => 'archivements', $contact->id]);}-->
                <!--    else{echo "not complete";}-->
                <!--?></td>-->
            </tr>
            <?php endforeach; ?>
        <?php } ?>
    </thead>
</table>


<table align="center" border="1">    
  
    <?php $i=0?>
    <thead>
        <tr>
            <th nowrap align="center" colspan="4">《獲得済み報酬》</th>
        </tr>
        <tr>
            
        <?php if($pushArchives!=null) { ?>  
            <?php foreach ($pushArchives as $contact): ?>
                <td><?php echo $this->Html->image($contact->address,array('title'=>$contact->reward,'width'=>'80','height'=>'80'),$i++);?></td>
                <?php if($i==4){?> </tr><tr> <?php $i=0; }?>
            <?php endforeach; ?>
        <?php } ?>
        
        <?php if($commentsArchives!=null) { ?>
            <?php foreach ($commentsArchives as $contact): ?>
                <td><?php echo $this->Html->image($contact->address,array('title'=>$contact->reward,'width'=>'80','height'=>'80'),$i++);?></td>
                <?php if($i==4){?> </tr><tr> <?php $i=0; }?>
            <?php endforeach; ?>
        <?php } ?>
        
        <?php if($favoritesArchives!=null) { ?>
            <?php foreach ($favoritesArchives as $contact): ?>
                <td><?php echo $this->Html->image($contact->address,array('title'=>$contact->reward,'width'=>'80','height'=>'80'),$i++);?></td>
                <?php if($i==4){?> </tr><tr> <?php $i=0; }?>
            <?php endforeach; ?>
        <?php } ?>
        
        <?php if($popularArchives!=null) { ?>
            <?php foreach ($popularArchives as $contact): ?>
                <td><?php echo $this->Html->image($contact->address,array('title'=>$contact->reward,'width'=>'80','height'=>'80'),$i++);?></td>
                <?php if($i==4){?> </tr><tr> <?php $i=0; }?>
            <?php endforeach; ?>
        <?php } ?>
        
        <?php if($otherArchives!=null) { ?>
            <?php foreach ($otherArchives as $contact): ?>
                <td><?php echo $this->Html->image($contact->address,array('title'=>$contact->reward,'width'=>'80','height'=>'80'),$i++);?></td>
                <?php if($i==4){?> </tr><tr> <?php $i=0; }?>
            <?php endforeach; ?>
        <?php } ?>
        
        </tr>
    </thead>
</table>
</html>