<div class="row">
    <div class="col-md-12">
        <div class="table-responsive">
            <table class="table table-border table-hover table-valign-middle" id="antMiners-table">
                <thead>
                    <th width="1%" class="text-center"><i class="fa fa-info-circle"></i></th>
                    <th width="5%" class="text-center" colspan="2">Title</th>
                    <th width="5%" class="text-center">Errors</th>
                    <th width="10%" class="text-center">TH/S</th>
                    <th width="13%" class="text-left">Board Temp,°C</th>
                    <th width="18%" class="text-left">Board Chips</th>
                    <th width="21%" class="text-left">Board Frequency</th>
                    <th width="7%" class="text-left">Fans</th>
                    <th width="10%" class="text-center"><i class="fa fa-arrows-v"></i></th>
                    <th width="100%" class="text-left"><i class="fa fa-cogs"></i></th>
                </thead>
                <tbody>
                @foreach($antMiners->sortBy('order') as $antMiner)
                    <tr>
                        <td class="bg-green">
                            <span style="margin-left: 3px;"><i class="fa fa-check-circle"></i></span>
                        </td>

                        <!-- TITLE -->
                        <td nowrap>
                            <a href="{!! route('antMiners.show', [$antMiner->id]) !!}">{!! $antMiner->title !!}</a>
                        </td>

                        <!-- MANAGE URL -->
                        <td>
                            @if($antMiner->url)
                                <a href="{{$antMiner->url}}" class='btn btn-xs btn-default' target="_blank"><i class="fa fa-external-link"></i></a>
                            @else
                                &nbsp;
                            @endif
                        </td>

                        @if($data[$antMiner->id])

                        <!-- ERRORS -->
                        <td class="text-center">
                            <a class='btn btn-{{$data[$antMiner->id]['hw'] < 0.001 ? 'success' : 'warning'}} btn-xs'>{!! $data[$antMiner->id]['hw'] !!}%</a>
                        </td>

                        <!-- HASHRATE -->
                        <td class="text-center">
                            <a class='btn btn-{{ $data[$antMiner->id]['hash_rate'] > $antMiner->hr_limit ? 'success' : 'warning'}} btn-xs ths'>{!! number_format(round(intval($data[$antMiner->id]['hash_rate'])/1000,2),2) !!}</a>
                        </td>



                        <!-- TEMP -->
                        <td class="text-left" nowrap="">
                            @foreach($data[$antMiner->id]['chains'] as $chain_index => $chain_data)
                                @if($antMiner->type == 'bmminer')
                                    <div class="btn-group">
                                        <a class='btn btn-{{ intval($chain_data['brd_temp1']) < $antMiner->temp_limit ? 'success' : 'warning'}} btn-xs miner-temp'>
                                            {{$chain_data['brd_temp1']}}°
                                        </a>
                                        <a class='btn btn-{{ intval($chain_data['brd_temp2']) < $antMiner->temp_limit ? 'success' : 'warning'}} btn-xs miner-temp'>
                                            {{$chain_data['brd_temp2']}}°
                                        </a>
                                    </div>
                                @else
                                    <a class='btn btn-{{ intval($chain_data['brd_temp']) < $antMiner->temp_limit ? 'success' : 'warning'}} btn-xs miner-temp2'>
                                        {{$chain_data['brd_temp']}}°
                                    </a>
                                @endif
                            @endforeach
                        </td>

                        <!-- Chips -->
                        <td class="text-left" nowrap>
                            @foreach($data[$antMiner->id]['chains'] as $chain_index => $chain_data)
                                <div class="btn-group">
                                    <a class="btn btn-success btn-xs chip-status">{{$chain_data['chips_condition']['ok']}}</a>
                                    <a class="btn btn-{{ $chain_data['chips_condition']['er'] <= 0 ? 'default' : 'danger'}} btn-xs chip-status">{{$chain_data['chips_condition']['er']}}</a>
                                </div>
                            @endforeach
                        </td>

                        <!--Board Freq -->
                        <td class="text-left" nowrap>
                            @if($data[$antMiner->id])
                                @foreach($data[$antMiner->id]['chains'] as $chain_index => $chain_data)
                                    <a class="btn btn-default btn-xs freq">B{{$loop->index + 1}}: {{intval($chain_data['brd_freq'])}}</a>
                                    <div class="progress vertical progress-xxs">
                                        <div class="progress-bar progress-bar-success progress-bar-striped" role="progressbar"
                                             aria-valuenow="{{intval($chain_data['brd_freq'])}}"
                                             aria-valuemin="100" aria-valuemax="1000"
                                             style="height: {{round(intval($chain_data['brd_freq']) * 100 / (1000 - 100))}}%">
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                        </td>

                        <!-- FANS -->
                        <td class="text-left" nowrap>
                            @foreach($data[$antMiner->id]['fans'] as $fan_id => $fan_speed)
                                <button class="btn btn-default btn-xs fan">{{title_case($fan_id)}}: {{$fan_speed}}</button>
                            @endforeach
                        </td>

                        @else
                        <td colspan="6" class="text-center">ERROR: miner is offline or unable to connect.</td>
                        @endif

                        <td class="text-center" nowrap>
                            @if($loop->first)
                                <a class="btn btn-default btn-xs" href="{{route('antMiners.desc',$antMiner->id)}}"> <i class="fa fa-angle-up"></i></a>
                            @elseif($loop->last)
                                <a class="btn btn-default btn-xs" href="{{route('antMiners.asc',$antMiner->id)}}"> <i class="fa fa-angle-down"></i></a>
                            @else
                                <a class="btn btn-default btn-xs" href="{{route('antMiners.asc',$antMiner->id)}}"> <i class="fa fa-angle-up"></i></a>
                                <a class="btn btn-default btn-xs" href="{{route('antMiners.desc',$antMiner->id)}}"> <i class="fa fa-angle-down"></i></a>
                            @endif
                        </td>

                        <td class="text-left">
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
        </div>
    </div>
</div>