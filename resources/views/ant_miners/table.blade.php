<table class="table table-border table-hover table-valign-middle" id="antMiners-table">
    <thead>
        <th width="1%" class="text-center">Title</th>
        <th width="1%" class="text-center small"></th>
        <th width="1%" class="text-center">TH/S</th>
        <th width="15%" class="text-left">Board Temp,°C</th>
        <th width="10%" class="text-left">Board CHIP Status</th>
        <th width="12%" class="text-center">B. Freq</th>
        <th width="1%" class="text-center hidden">HW</th>

        <th width=""   class="text-left">FANs, rpm</th>

        <th colspan="2"  class="text-center hidden-xs">Notification warnings</th>
        <th width=""   class="text-right"><i class="fa fa-cogs"></i> </th>
    </thead>
    <tbody>
    @foreach($antMiners->sortBy('user_id') as $antMiner)
        <tr>
            <!-- TITLE -->
            <td class="small" nowrap>
                <a href="{!! route('antMiners.show', [$antMiner->id]) !!}">{!! $antMiner->title !!}</a>
            </td>
            <!-- MANAGE URL -->

            <td>
                @if($antMiner->url)
                    <a href="{{$antMiner->url}}" class='btn btn-default btn-xs' target="_blank"><i class="glyphicon glyphicon-share"></i></a>
                @else
                    <a href="#" class='btn btn-default btn-xs disabled' target="_blank"><i class="glyphicon glyphicon-share"></i></a>
                @endif
            </td>

            @if($data[$antMiner->id])
                <!-- HASHRATE -->
                <td class="text-center">
                    @if (isset($antMiner->temp_limit))
                        @if(round(intval($data[$antMiner->id]['hash_rate'])/1000,2) == 0)
                            <button class="btn btn-danger btn-xs ths">{!! round(intval($data[$antMiner->id]['hash_rate'])/1000,2) !!}</button>
                        @elseif(round(intval($data[$antMiner->id]['hash_rate'])/1000,2) > $antMiner->temp_limit)
                            <button class="btn btn-warning btn-xs ths">{!! round(intval($data[$antMiner->id]['hash_rate'])/1000,2) !!}</button>
                        @else
                            <button class="btn btn-default btn-xs ths">{!! round(intval($data[$antMiner->id]['hash_rate'])/1000,2) !!}</button>
                        @endif
                    @else
                        <button class="btn btn-default btn-xs ths">{!! round(intval($data[$antMiner->id]['hash_rate'])/1000,2) !!}</button>
                    @endif
                </td>

                <!-- TEMP -->
                <td class="text-left small" nowrap="">
                    @foreach($data[$antMiner->id]['chains'] as $chain_index => $chain_data)
                        @if($antMiner->type == 'bmminer')
                            <div class="btn-group">
                                @if(intval($chain_data['brd_temp1']) > 95)
                                    <button class="btn btn-danger btn-xs miner-temp"> {{$chain_data['brd_temp1']}}°</button>
                                @elseif(intval($chain_data['brd_temp1']) > 88)
                                    <button class="btn btn-warning btn-xs miner-temp"> {{$chain_data['brd_temp1']}}°</button>
                                @else
                                    <button class="btn btn-success btn-xs miner-temp"> {{$chain_data['brd_temp1']}}°</button>
                                @endif

                                @if(intval($chain_data['brd_temp2']) > 95)
                                    <button class="btn btn-danger btn-xs miner-temp"> {{$chain_data['brd_temp2']}}°</button>
                                @elseif(intval($chain_data['brd_temp2']) > 88)
                                    <button class="btn btn-warning btn-xs miner-temp"> {{$chain_data['brd_temp2']}}°</button>
                                @else
                                    <button class="btn btn-success btn-xs miner-temp"> {{$chain_data['brd_temp2']}}°</button>
                                @endif
                            </div>
                        @else
                            @if(intval($chain_data['brd_temp']) > 79)
                                <button class="btn btn-danger btn-xs miner-temp"> {{$chain_data['brd_temp']}}°</button>
                            @elseif(intval($chain_data['brd_temp']) > 75)
                                <button class="btn btn-warning btn-xs miner-temp"> {{$chain_data['brd_temp']}}°</button>
                            @else
                                <button class="btn btn-success btn-xs miner-temp"> {{$chain_data['brd_temp']}}°</button>
                            @endif
                        @endif
                    @endforeach
                </td>

                <!-- Chips -->
                <td class="text-left small" nowrap>
                    @foreach($data[$antMiner->id]['chains'] as $chain_index => $chain_data)
                        <div class="btn-group">
                            @if(intval($chain_data['chips_condition']['ok'])>0)
                                <button class="btn btn-success btn-xs chip-status">{{$chain_data['chips_condition']['ok']}}</button>
                            @else
                                <button class="btn btn-danger btn-xs chip-status">&mdash;</button>
                            @endif
                            <button class="btn @if(intval($chain_data['chips_condition']['er']) > 0) btn-danger @else btn-default @endif btn-xs chip-status">{{$chain_data['chips_condition']['er']}}</button>
                        </div>
                    @endforeach
                </td>

                <!--Board Freq -->
                <td class="text-left" nowrap>
                    @if($data[$antMiner->id])

                        @foreach($data[$antMiner->id]['chains'] as $chain_index => $chain_data)
                            @if(round(intval($chain_data['brd_freq']),0) > 774)
                                <button class="btn btn-default btn-xs freq">B{{$chain_index}}: {{round(intval($chain_data['brd_freq']),0)}}</button>
                                <div class="progress vertical progress-xxs">
                                    <div class="progress-bar progress-bar-danger progress-bar-striped" role="progressbar" style="height: 100%">
                                    </div>
                                </div>
                            @elseif(round(intval($chain_data['brd_freq']),0) > 749)
                                <button class="btn btn-default btn-xs freq">B{{$chain_index}}: {{round(intval($chain_data['brd_freq']),0)}}</button>
                                <div class="progress vertical progress-xxs">
                                    <div class="progress-bar progress-bar-warning progress-bar-striped" role="progressbar" style="height: 70%">
                                    </div>
                                </div>
                            @else
                                <button class="btn btn-default btn-xs freq">B{{$chain_index}}: {{round(intval($chain_data['brd_freq']),0)}}</button>
                                <div class="progress vertical progress-xxs">
                                    <div class="progress-bar progress-bar-success progress-bar-striped" role="progressbar" style="height: 50%">
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    @endif
                </td>

                <!-- HW Errors -->
                <td class="text-center hidden">
                    -
                </td>

                <!-- FANS -->
                <td class="text-left small" nowrap>
                    @foreach($data[$antMiner->id]['fans'] as $fan_id => $fan_speed)
                        <button class="btn btn-default btn-xs fan">{{title_case($fan_id)}}: {{$fan_speed}}</button>
                    @endforeach
                </td>

                <td class="text-center small hidden-xs">@if (isset($antMiner->temp_limit)) {{$antMiner->temp_limit}}° @else &mdash; @endif</td>
                <td class="text-center small hidden-xs">@if (isset($antMiner->hr_limit)) {{round($antMiner->hr_limit/1000,2)}} TH/s @else &mdash; @endif</td>
            @else
                    <td colspan="7" class="text-center">ERROR: miner is offline or unable to connect.</td>
            @endif


            <td class="text-right">
                {!! Form::open(['route' => ['antMiners.destroy', $antMiner->id], 'method' => 'delete']) !!}
                <div class='btn-group'>
                    <a href="{!! route('antMiners.edit', [$antMiner->id]) !!}" class='btn btn-default btn-xs'><i class="fa fa-cog"></i></a>
                    {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                </div>
                {!! Form::close() !!}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
