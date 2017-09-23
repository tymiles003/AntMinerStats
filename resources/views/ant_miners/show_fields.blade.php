@include('flash::message')
<div class="clearfix"></div>
<div class="row">
    @if($stats['summary'])
        <!-- STATUS INFO-->
        <div class="col-sm-12">
            <div class="box box-primary miner-info">
                <div class="box-header with-border">
                    <h3 class="box-title">Status information</h3>
                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                        <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                    </div>
                </div>
                <div class="box-body">
                    <div class="row">
                        <!-- HASHRATE -->
                        <div class="col-sm-2 col-xs-6 border-right">
                            <div class="description-block">
                                <div class="description-text"><i class="fa fa-cog fa-spin"></i> Hashrate </div>
                                <div class="description-header">{!! round(intval($stats['summary']['GHS 5s'])/1000,2) !!} / {!! round(intval($stats['summary']['GHS av'])/1000,2) !!}</div>
                            </div>
                        </div>
                            <!-- UPTIME -->
                            <div class="col-sm-2 col-xs-6 border-right">
                                <div class="description-block">
                                    <span class="description-text"><i class="fa fa-rocket"></i> Uptime</span>
                                    <h5 class="description-header">{{ gmdate('d',$stats['summary']['Elapsed']) - 1 }}d {{ gmdate('H',$stats['summary']['Elapsed']) }}h {{ gmdate('i',$stats['summary']['Elapsed']) }}m  {{ gmdate('s',$stats['summary']['Elapsed']) }}s</h5>
                                </div>
                            </div>
                            <!-- HW -->
                            <div class="col-sm-2 col-xs-6 border-right">
                                <div class="description-block">
                                <span class="description-text">
                                    <i class="fa fa-star"></i> HW errors</span>
                                    <h5 class="description-header">{{$stats['summary']['Device Hardware%']}} %</h5>
                                </div>
                            </div>

                            <!-- BOARD FREQ -->
                            <div class="col-sm-2 col-xs-6 border-right">
                                <div class="description-block">
                                    <span class="description-text"><i class="fa fa-wrench"></i> Board freq.</span>
                                    <h5 class="description-header">

                                        @php
                                            $board_freq = 0;
                                            foreach($stats['stats']['chains'] as $chain_index => $chain_data)
                                            {
                                                $board_freq = $board_freq + $chain_data['brd_freq'];
                                            }
                                        @endphp

                                        {{round($board_freq / count($stats['stats']['chains']), 0)}} <small>Mhz</small>

                                    </h5>
                                </div>
                            </div>
                            <!-- FANS -->
                            <div class="col-sm-2 col-xs-6 border-right">
                                <div class="description-block">
                                    <span class="description-text"><img src="/images/fan.png" width="16"> Fans</span>
                                    <h5 class="description-header">
                                        @foreach($stats['stats']['fans'] as $fan)
                                            {{$fan}}
                                        @endforeach
                                        <small>rpm</small>
                                    </h5>
                                </div>
                            </div>
                            <!-- BLOCKS -->
                            <div class="col-sm-2 col-xs-6 border-right">
                                <div class="description-block">
                                    <span class="description-text"><i class="fa fa-star"></i> Blocks</span>
                                    <h5 class="description-header">{{$stats['summary']['Found Blocks']}}</h5>
                                </div>
                            </div>
                        </div>
                </div>
            </div>
        </div>
    @endif

    @if($stats['stats'])
        <!-- CHIPS INFO -->
            <div class="col-sm-12">
                <div class="box box-success">
                    <div class="box-header with-border">
                        <h3 class="box-title">Chips status</h3>
                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                            <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                        </div>
                    </div>
                    <div class="box-body">
                        <div class="table-responsive">
                            <table class="table table-">
                                <thead>
                                    <th class="text-center">Board</th>
                                    <th class="text-center">Temp</th>
                                    <th class="text-center">FREQ</th>
                                    <th class="text-center">Chips</th>
                                    <th class="text-left">Chips info</th>
                                </thead>
                                <tbody>
                                @foreach($stats['stats']['chains'] as $chain_index => $chain_data)
                                    <tr>
                                        <td class="text-center">#{{$chain_index}}</td>
                                        <td class="text-center">
                                            @foreach($chain_data['brd_temp'] as $brd_temp){{$brd_temp}}
                                                @if(!$loop->last) / @endif
                                            @endforeach
                                            &deg;
                                        </td>
                                        <td class="text-center">{{$chain_data['brd_freq']}} <small>Mhz</small></td>
                                        <td class="text-center">{{$chain_data['chips']}}</td>
                                        <td class="text-left">
                                            @foreach($chain_data['chips_stat'] as $chip)
                                                @if($chip == 'o')
                                                    <i class="fa fa-circle" style="color: gray; font-size: 60%;" ></i>
                                                @else
                                                    <i class="fa fa-times-circle" style="color: red; font-size: 60%;" ></i>
                                                @endif
                                            @endforeach
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
    @endif

    @if($stats['pools'])
        <!-- POOL INFO -->
        <div class="col-sm-12">
            <div class="box box-warning">
                <div class="box-header with-border">
                    <h3 class="box-title">Pool information</h3>
                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                        <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                    </div>
                </div>
                <div class="box-body">
                    <div class="table-responsive">
                            <!-- POLL INFO -->
                            <table class="table table-bordered table-hover table-condensed">
                                <thead>
                                <tr>
                                    <th class="text-center">Pool</th>
                                    <th>URL</th>
                                    <th>User</th>
                                    <th class="text-center">Status</th>
                                    <th class="text-center">Diff</th>
                                    <th class="text-center">GetWorks</th>
                                    <th class="text-center">Accepted</th>
                                    <th class="text-center">Discarded</th>
                                    <th class="text-center">Rejected</th>
                                    <th class="text-center">LSTime</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($stats['pools'] as $pool)
                                    <tr>
                                        <td class="text-center">{{$pool['POOL']}}</td>
                                        <td>{{$pool['URL']}}</td>
                                        <td>{{$pool['User']}}</td>
                                        <td class="text-center">{{$pool['Status']}}</td>
                                        <td class="text-center">{{$pool['Diff']}}</td>
                                        <td class="text-center">{{$pool['Getworks']}}</td>
                                        <td class="text-center">{{$pool['Accepted']}}</td>
                                        <td class="text-center">{{$pool['Discarded']}}</td>
                                        <td class="text-center">{{$pool['Rejected']}}</td>
                                        <td class="text-center">{{$pool['Last Share Time']}}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                </div>
            </div>
        </div>
    @endif

    <!-- GRAPHICS -->
    <div class="col-sm-12">
        <div class="box box-danger">
            <div class="box-header with-border">
                <h3 class="box-title">Graphics</h3>
                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                    <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                </div>
            </div>
            <div class="box-body">

                <div id="temps_div"></div>
                <div id="freqs_div"></div>
                <div id="hr_div"></div>
                <div id="hw_div"></div>
                <div id="cc_div"></div>

                <?= Lava::render('LineChart', 'Temps', 'temps_div') ?>
                <?= Lava::render('LineChart', 'Freqs', 'freqs_div') ?>
                <?= Lava::render('LineChart', 'HashRate', 'hr_div') ?>
                <?= Lava::render('LineChart', 'HWERR', 'hw_div') ?>
                <?= Lava::render('LineChart', 'Chips', 'cc_div') ?>

            </div>
        </div>
    </div>
</div>







