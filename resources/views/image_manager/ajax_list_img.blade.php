		<?php if(isset($image_list)):?>
			<?php $i=0;?>
			<?php foreach($image_list as $row):?>
			<?php $i++;?>
			
			<?php if($i !=1 && $i%6==1):?>
				</div>
				<div class="row">
			<?php endif;?>
			<?php if($i==1):?>
			<div class="row">
			<?php endif;?>

			<div class="col-md-2"  data-date-created="<?php echo $row['created_at']?>" data-title="background3" style="overflow:hidden">
					<div class="thumbnail">
						<img src="<?php echo url().'/'.$row['img_preview']?>" alt="...">
						<div class="caption">
						<div style="height:20px;overflow:hidden">
							<?php echo (($row['caption'])?$row['caption']:'-')?>
						</div>
						<p>
						<small class="text-muted"><?php echo $row['created_at']?></small>
						</p>
						<div class="row">
							<div class="col-md-12 text-center">
							<button class="btn btn-info  btn-xs" type="button" onclick="window.parent.insert_image('<?php echo $row['id']?>','<?php echo url().'/'.$row['img_preview']?>','<?php echo $row['img_preview']?>')"><i class="ico-check"></i> Pilih</button>
							</div>
						</div>
						</div>
					</div>
				</div>			
			
			<?php endforeach;?>
			<?php if($i !=0):?>
				</div>
			<?php endif;?>
			<?php endif;?>		