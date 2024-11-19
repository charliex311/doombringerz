@extends('layouts.cabinet')

@section('title', __('Колесо удачи'))

@section('wrap')
    <div class="nk-block">
        <div class="row g-gs">
            <div class="col-12">

				<link rel="stylesheet" href="{{ asset('wheel/wheel.css') }}"/>
				<div class="card card-bordered" style="margin-bottom: 10px;">
                    <div class="card-inner">
                        <div class="card-title-group">
                            <h5 class="card-title">
                                <span class="mr-2">@yield('title')</span>
                            </h5>
                        </div>
                    </div>
                </div>
				<div class="wheel-box">
					<div class="wheel-box__col">
						<div class="wheel" data-item-count="@php echo count($items); @endphp" id="wheel">
							<div class="wheel__container">
								@if(isset($items))
									@foreach($items as $item)
										<div class="wheel__sector" data-item-id="{{ $item['id'] }}" data-item-name="{{ $item['name'] }}">
											<div class="wheel__item-icon"><img src="{{ $item['image'] }}" alt=""></div>
										</div>
									@endforeach
								@endif
							</div>
							<div class="wheel__update" id="wheel-update"></div>
						</div>
						<div class="wheel-result">
							<div class="wheel-result__button wheel-result__button--show btn btn-lg btn-outline-primary" id="wheel-button" @if($free_spin) data-free="1" @else data-free="0" @endif>
								<div class="btn-play">{{ __('Играть в игру!') }}</div>

								    <span class="free-spin" @if(!$free_spin) style="display: none;" @endif>{{ __('Бесплатно') }}</span>
                                    <span class="pay-spin" @if($free_spin) style="display: none;" @endif>{{ __('Цена') }}: {{ config('options.lwitems_cost', '1') }} {{ config('options.server_0_coin_short_name', 'CoL') }}</span>

							</div>
							<div id="alert-text" style="display:none;">{{ __('Вы уверены, что хотите приобрести вращение Lucky Wheel за 3 DP?') }}</div>

							<div class="wheel-result__reward" id="wheel-reward">
								<div class="wheel-result__reward-desc">{{ __('Ваша награда') }}:</div>
								<div class="wheel-result__reward-name"></div>
							</div>

							<div class="wheel-result__processing" id="wheel-processing">
								<div class="wheel-result__processing-text">{{ __('Открытие') }}...</div>
								<div class="wheel-result__brogress">
									<div class="wheel-result__brogress-bar"></div>
								</div>
							</div>
						</div>
					</div>
					<div class="wheel-box__col">
						<div class="item-list">
							<div class="item-list__title">{{ __('Наградные предметы') }}</div>
							<div class="item-list__items" id="wheel-rewards">

								@if (isset($items))
									@foreach($items as $item)
										<div class="item-list__item">
											<div class="item-list__item-icon"><img src="{{ $item['image'] }}" alt="{{ $item['name'] }}"></div>
											<div class="item-list__item-info">
												<div class="item-list__item-name">{{ $item['name'] }}</div>
												<div class="item-list__item-desc">{{ __('Шанс выпадения') }}: <span>{{ $item['chance'] }}%</span></div>
											</div>
										</div>
									@endforeach
								@endif

							</div>
						</div>
					</div>
				</div>
				<script src="{{ asset('wheel/wheel.js') }}"></script>
            </div>
        </div>
    </div>

	<div class="modal fade zoom" tabindex="-1" id="LuckyweelWin">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<a href="#" class="close" data-dismiss="modal" aria-label="Close">
					<em class="icon ni ni-cross"></em>
				</a>
				<div class="modal-header">
					<h5 class="modal-title">{{ __('Поздравляем') }}</h5>
				</div>

				<div class="modal-body">
					<div class="form-group">
						<div class="form-control-wrap">
							<p>{{ __('Поздравляем, вы выиграли') }}: <span id="win-item"></span></p>
						</div>
					</div>
				</div>
				<div class="modal-footer bg-light">
					<button type="submit" class="btn btn-lg btn-primary btn-close"><span>{{ __('Спасибо') }}</span></button>
				</div>

			</div>
		</div>
	</div>

@endsection
@push('scripts')
	<script>
		$('.modal .close, .modal .btn-close').click(function () {
			$('#LuckyweelWin').removeClass('show');
		});
	</script>
@endpush

