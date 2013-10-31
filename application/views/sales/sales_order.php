<h2>Sales Order</h2>
<div class="clr search_details">
					<div class="search span3">
						<h6>Search</h6>
						<div class="clr">
							<div class="clr search_box">
								<div class="clr">
									<span class="fl">Order#</span>
									<span class="fr"><input type="text" /></span>
								</div>
								<div class="clr">
									<span class="fl">Status</span>
									<span class="fr">
										<select>
											<option>All</option>
											<option>test</option>
											<option>test</option>
											<option>test</option>
										</select>
									</span>
								</div>
								<div class="clr">
									<span class="fl">Customer</span>
									<span class="fr">
										<select class="">
											<option>Rahim</option>
											<option>Karim</option>
											<option>billal</option>
										</select>
									</span>
								</div>
								<div class="clr more_link">
									<span class="fl"> <a href="#">>more</a></span>
									<span class="fr">
										<button>Search</button>
									</span>
								</div>
							</div>
							<div class="clr order-status hndrd">
								<div class="fifty fl">
									<h3>Order#</h3>
									<div class="clr">SO-000009</div>
									<div class="clr">SO-000008</div>
									<div class="clr">SO-000007</div>							
								</div>
								<div class="fifty fr">
									<h3>Status</h3>
									<div class="clr">Open</div>
									<div class="clr">In Progress</div>
									<div>Paid</div>
								</div>
							</div>
						</div>
					</div>
					<div class="details_nav hundrd span8">
						<ul>
							<li><a href="#">New</a></li>
							<li><a href="#">Save</a></li>
							<li><a href="#">Print</a></li>
							<li><a href="#">Duplicate</a></li>
							<li><a href="#">Versions</a></li>
							<li><a href="#">Add Sticky</a></li>
							<li><a href="#">Close</a></li>
						</ul>
					</div>
					<div class="details hundrd span9">				
						<div class="clr">
							<div class="thirty_percnt customer1 san3">						
								<div class="clr">
									<span class="fl">Customer</span>
									<span class="fr">
										<a href="<?php echo base_url("./Sales/customerSelect");?>">Customer Select</a>
									</span>
								</div>
								<div class="clr">
									<span class="fl">Customer</span>
									<span class="fr">
										<select>
											<option>All</option>
											<option>test</option>
											<option>test</option>
											<option>test</option>
										</select>
									</span>
								</div>	
								<div class="clr">
									<span class="fl">Contact</span>
									<span class="fr"><input type="text" /></span>
								</div>
								<div class="clr">
									<span class="fl">Phone</span>
									<span class="fr"><input type="text" /></span>
								</div>				
								<div class="clr">
									<span class="fl">Address</span>
									<span class="fr">
									<Textarea>Box 491, New South Wales, Australia.</textarea>
									</span>
								</div>						
							</div>
							<div class="thirty_percnt customer2 span3">						
								<div class="clr">
									<span class="fl">Sales Rep</span>
									<span class="fr">
										<select>
											<option>All</option>
											<option>test</option>
											<option>test</option>
											<option>test</option>
										</select>
									</span>
								</div>
								<div class="clr">
									<span class="fl">Location</span>
									<span class="fr">
										<select>
											<option>All</option>
											<option>test</option>
											<option>test</option>
											<option>test</option>
										</select>
									</span>
								</div>																					
							</div>
							<div class="thirty_percnt customer3 span3">												
								<div class="clr">
									<span class="fl">Order #</span>
									<span class="fr"><input type="text" /></span>
								</div>
								<div class="clr">
									<span class="fl">Date</span>
									<span class="fr">
										<select>
											<option>All</option>
											<option>test</option>
											<option>test</option>
											<option>test</option>
										</select>
									</span>
								</div>						
								<div class="clr">
									<span class="fl">Status</span>
									<span class="fr"><input type="text" value="open" /></span>
								</div>																		
							</div>
						</div>
						<div class="clr product_details">
							<div style="width:3%;" class="blank_div">
								<p style="background-image:none;">&nbsp;</p>
								<p>&nbsp;</p>
								<p>&nbsp;</p>
								<p>&nbsp;</p>
							</div>
							<div>
								<h3>Item</h3>
								<a class="product_select" href="./product_select.php">product Select</a>
								<input class="snd_raw" type="text" value="0000098"/>
								<input type="text" value="0000047"/>
							</div>
							<div>
								<h3>Description</h3>
								<input type="text" value="Acer"/>
								<input class="snd_raw" type="text" value="dell"/>
								<input type="text" value="asus"/>
							</div>
							<div>
								<h3>Quantity</h3>
								<input type="text" value="Acer"/>
								<input class="snd_raw" type="text" value="dell"/>
								<input type="text" value="asus"/>
							</div>
							<div>
								<h3>Unit Price</h3>
								<input type="text" value="Acer"/>
								<input class="snd_raw" type="text" value="dell"/>
								<input type="text" value="asus"/>
							</div>
							<div>
								<h3>Discount</h3>
								<input type="text" value="Acer"/>
								<input class="snd_raw" type="text" value="dell"/>
								<input type="text" value="asus"/>
							</div>
							<div>
								<h3>Sub-Total</h3>
								<input type="text" value="Acer"/>
								<input class="snd_raw" type="text" value="dell"/>
								<input type="text" value="asus"/>
							</div>
							<div class="clr payment_info">
								<div class="block block1">
									<div class="clr span12">
										<span class="fl">Taxing Scheme</span>
										<span class="fr">
											<select>
												<option>No Tax</option>
												<option>Add New</option>
											</select>
										</span>										
									</div>
									<div class="clr span12">
										<span class="fl">Pricing/Currency</span>
										<span class="fr">
											<select>
												<option>Normal Price</option>
												<option>Add New</option>
											</select>
										</span>										
									</div>
								</div>
								<div class="block block2">
									<div class="clr span12">
										<span class="fl">Remarks</span>
										<span class="fr">
											<textarea></textarea>
										</span>										
									</div>
								</div>
								<div class="block block3">
									<div class="clr span12">
										<span class="fl">Sub-Total</span>
										<span class="fr">
											$0.00
										</span>										
									</div>
									<div class="clr span12">
										<span class="fl">Total</span>
										<span class="fr">
											$0.00
										</span>										
									</div>
								</div>
							</div>
							<p class="clr">&nbsp;</p>
						</div>
					</div>					
					<p class="clr">&nbsp;</p>
				</div>
			