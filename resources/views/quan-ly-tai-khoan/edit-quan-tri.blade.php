@extends('layouts.main')
@section('title', "Thông tin cá nhân")
@section('content')
<div class="m-content">
						<div class="row">
							<!-- <div class="col-xl-3 col-lg-4">
								<div class="m-portlet m-portlet--full-height  ">
									<div class="m-portlet__body">
										<div class="m-card-profile">
											<div class="m-card-profile__title m--hide">
												Trang cá nhân
											</div>
											<div class="m-card-profile__pic">
												<div class="m-card-profile__pic-wrapper">
													<img src="../assets/app/media/img/users/user4.jpg" alt="" />
												</div>
											
											</div>
											<div class="m-card-profile__details">
												<span class="m-card-profile__name">Name </span>
												<a href="" class="m-card-profile__email m-link">Email</a>
											</div>
										</div>
										<ul class="m-nav m-nav--hover-bg m-portlet-fit--sides">
											<li class="m-nav__separator m-nav__separator--fit"></li>
											<li class="m-nav__section m--hide">
												<span class="m-nav__section-text">Section</span>
											</li>
											<li class="m-nav__item">
												<a href="../header/profile&amp;demo=default.html" class="m-nav__link">
													<i class="m-nav__link-icon flaticon-profile-1"></i>
													<span class="m-nav__link-title">
														<span class="m-nav__link-wrap">
															<span class="m-nav__link-text">My Profile</span>
															<span class="m-nav__link-badge"><span class="m-badge m-badge--success">2</span></span>
														</span>
													</span>
												</a>
											</li>
											<li class="m-nav__item">
												<a href="../header/profile&amp;demo=default.html" class="m-nav__link">
													<i class="m-nav__link-icon flaticon-share"></i>
													<span class="m-nav__link-text">Activity</span>
												</a>
											</li>
											<li class="m-nav__item">
												<a href="../header/profile&amp;demo=default.html" class="m-nav__link">
													<i class="m-nav__link-icon flaticon-chat-1"></i>
													<span class="m-nav__link-text">Messages</span>
												</a>
											</li>
											<li class="m-nav__item">
												<a href="../header/profile&amp;demo=default.html" class="m-nav__link">
													<i class="m-nav__link-icon flaticon-graphic-2"></i>
													<span class="m-nav__link-text">Sales</span>
												</a>
											</li>
											<li class="m-nav__item">
												<a href="../header/profile&amp;demo=default.html" class="m-nav__link">
													<i class="m-nav__link-icon flaticon-time-3"></i>
													<span class="m-nav__link-text">Events</span>
												</a>
											</li>
											<li class="m-nav__item">
												<a href="../header/profile&amp;demo=default.html" class="m-nav__link">
													<i class="m-nav__link-icon flaticon-lifebuoy"></i>
													<span class="m-nav__link-text">Support</span>
												</a>
											</li>
										</ul>
										<div class="m-portlet__body-separator"></div>
										
									</div>
								</div>
							</div> -->
							<div class="col-xl-12 col-lg-9">
								<div class="m-portlet m-portlet--full-height m-portlet--tabs  ">
									<div class="m-portlet__head">
										<div class="m-portlet__head-tools">
											<ul class="nav nav-tabs m-tabs m-tabs-line   m-tabs-line--left m-tabs-line--primary" role="tablist">
												<li class="nav-item m-tabs__item">
													<a class="nav-link m-tabs__link active" data-toggle="tab" href="#m_user_profile_tab_1" role="tab">
														<i class="flaticon-share m--hide"></i>
														Cập nhật tài khoản
													</a>
												</li>
												
											</ul>
										</div>
										<div class="m-portlet__head-tools">
											<ul class="m-portlet__nav">
												<li class="m-portlet__nav-item m-portlet__nav-item--last">
													<div class="m-dropdown m-dropdown--inline m-dropdown--arrow m-dropdown--align-right m-dropdown--align-push" m-dropdown-toggle="hover" aria-expanded="true">
														<a href="#" class="m-portlet__nav-link btn btn-lg btn-secondary  m-btn m-btn--icon m-btn--icon-only m-btn--pill  m-dropdown__toggle">
															<i class="la la-gear"></i>
														</a>
														<div class="m-dropdown__wrapper">
															<span class="m-dropdown__arrow m-dropdown__arrow--right m-dropdown__arrow--adjust"></span>
															<div class="m-dropdown__inner">
																<div class="m-dropdown__body">
																	<div class="m-dropdown__content">
																		<ul class="m-nav">
																			<li class="m-nav__section m-nav__section--first">
																				<span class="m-nav__section-text">Quick Actions</span>
																			</li>
																			<!-- <li class="m-nav__item">
																				<a href="{{route('doi-mat-khau', ['id' =>Auth::user()->id])}}" class="m-nav__link">
																					<i class="m-nav__link-icon flaticon-share"></i>
																					<span class="m-nav__link-text">Đổi Mật khẩu</span>
																				</a>
																			</li> -->
																			
																			
																			<li class="m-nav__section">
																				<span class="m-nav__section-text">Useful Links</span>
																			</li>
																			<li class="m-nav__item">
																				<a href="" class="m-nav__link">
																					<i class="m-nav__link-icon flaticon-info"></i>
																					<span class="m-nav__link-text">FAQ</span>
																				</a>
																			</li>
																			<li class="m-nav__item">
																				<a href="" class="m-nav__link">
																					<i class="m-nav__link-icon flaticon-lifebuoy"></i>
																					<span class="m-nav__link-text">Trợ giúp</span>
																				</a>
																			</li>
																			<li class="m-nav__separator m-nav__separator--fit m--hide">
																			</li>
																			<li class="m-nav__item m--hide">
																				<a href="#" class="btn btn-outline-danger m-btn m-btn--pill m-btn--wide btn-sm">Submit</a>
																			</li>
																		</ul>
																	</div>
																</div>
															</div>
														</div>
													</div>
												</li>
											</ul>
										</div>
									</div>
									<div class="tab-content">
										<div class="tab-pane active" id="m_user_profile_tab_1">
											<form class="m-form m-form--fit m-form--label-align-right" method="POST" action="{{route('update-admin', ['id' =>$user->id])}}" >
												@csrf
												<div class="m-portlet__body">
													<div class="form-group m-form__group m--margin-top-10 m--hide">
														<div class="alert m-alert m-alert--default" role="alert">
															
														</div>
														@auth
													</div>
													<?php 
															$message = Session::get('message');
															if ($message) {
																echo '<div class="alert alert-success">'. $message .'</div>';
																Session::put('message', null);
															}
														?>
													<div class="form-group m-form__group row">
														<div class="col-10 ml-auto">
															<h3 class="m-form__section">Thông tin cá nhân</h3>
														</div>
													</div>
													<div class="form-group m-form__group row">
														<label for="example-text-input"  class="col-2 col-form-label">Họ tên</label>
														<div class="col-7">
														@error('name')
															<small style="color:red">{{$message}}</small>
															@enderror
															<input class="form-control m-input" type="text" name="name"   value="{{$user->name }}">
														</div>
													</div>
													<div class="form-group m-form__group row" >
														<label for="example-text-input" class="col-2 col-form-label" name="email">Email</label>
														<div class="col-7">
														@error('email')
															<small style="color:red">{{$message}}</small>
															@enderror
															<input class="form-control m-input " type="text" name="email"  value="{{$user->email }}">
														</div>
													</div>
													

													<!-- <div class="form-group m-form__group row">
														<label for="example-text-input" class="col-2 col-form-label">Số điện thoại</label>
														<div class="col-7">
															<input class="form-control m-input" type="text" value="CTO">
														</div>
													</div> -->
													<!-- <div class="form-group m-form__group row">
														<label for="example-text-input" class="col-2 col-form-label">Company Name</label>
														<div class="col-7">
															<input class="form-control m-input" type="text" value="Keenthemes">
															<span class="m-form__help">If you want your invoices addressed to a company. Leave blank to use your full name.</span>
														</div>
													</div> -->
												<!-- 	<div class="form-group m-form__group row">
														<label for="example-text-input" class="col-2 col-form-label">Email</label>
														<div class="col-7">
															<input class="form-control m-input" type="text" value="{{Auth::user()->email }}">
														</div>
													</div>
													<div class="m-form__seperator m-form__seperator--dashed m-form__seperator--space-2x"></div>
													<div class="form-group m-form__group row">
														<div class="col-10 ml-auto">
															<h3 class="m-form__section">2. Address</h3>
														</div>
													</div>
													<div class="form-group m-form__group row">
														<label for="example-text-input" class="col-2 col-form-label">Address</label>
														<div class="col-7">
															<input class="form-control m-input" type="text" value="L-12-20 Vertex, Cybersquare">
														</div>
													</div>
													<div class="form-group m-form__group row">
														<label for="example-text-input" class="col-2 col-form-label">City</label>
														<div class="col-7">
															<input class="form-control m-input" type="text" value="San Francisco">
														</div>
													</div>
													<div class="form-group m-form__group row">
														<label for="example-text-input" class="col-2 col-form-label">State</label>
														<div class="col-7">
															<input class="form-control m-input" type="text" value="California">
														</div>
													</div>
													 -->
												
												</div>
												<div class="m-portlet__foot m-portlet__foot--fit">
													<div class="m-form__actions">
														<div class="row">
															<div class="col-2">
															</div>
															<div class="col-7">
																<button type="submit" class="btn btn-accent m-btn m-btn--air m-btn--custom">Cập nhật</button>&nbsp;&nbsp;
																<a href="{{route('account.index')}}">Quay lại</a>
															</div>
														</div>
													</div>
												</div>
												@endauth
											</form>
										</div>
										<div class="tab-pane " id="m_user_profile_tab_2">
										</div>
										<div class="tab-pane " id="m_user_profile_tab_3">
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
@endsection