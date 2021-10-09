	<!--scrollbar start-->
	@if (!$scrollmessageList->isEmpty())
		<section id="scroll_section" class="scroll_body">
			<div class="container">
				<div class="row">
					<div class="marquee marquee2">
						
							<?php 
							$str = '';
							?>
							@foreach($scrollmessageList as $message)
								<?php $str .='<span class="envelop_icon">&nbsp;</span> '.$message->message.'&nbsp;&nbsp;'; ?>
							@endforeach
							<?php
								echo trim($str," | ");
							?>
					
					</div>
				</div>
			</div>
		</section>
	@endif
	<!--end scrollbar section -->