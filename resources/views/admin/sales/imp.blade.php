
                        <div class="row form-row justify-content-center" style="margin-top:26px;">
                            <div class="col-md-6 col-lg-12">
                                <div class="card card-table">
                                    {{--  <div class="card-header">
                                        <p class="card-title">Télécharger le dernier reçu de vente du jour</p>
                                    </div>  --}}
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table id="sales-table" class="datatable table table-hover table-center mb-0">
                                                <thead>
                                                    <tr>
                                                        {{--  <th>N°</th>  --}}
                                                        <th>Client</th>
                                                        {{--  <th>Produit</th>  --}}
                                                        <th>Heure</th>
                                                        <th><i class="fa fa-print" aria-hidden="true"></i></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php $i = 1; ?>
                                                    @foreach ($sales as $sale)
                                                        <tr>
                                                            {{--  <td>{!! $i++ !!}</td>  --}}
                                                            <td>{!! $sale->nom_client ?? '' !!}</td>
                                                            {{--  <td>{!! $sale->product->purchase->product ?? '' !!}</td>  --}}
                                                            {{--  <td>{!! optional($sale->created_at)->translatedFormat('H\h:i') ?? '' !!}</td>  --}}
                                                            {{--  <td>{!! optional($sale->created_at)->translatedFormat('d F Y à H\h i') ?? '' !!}</td>  --}}
                                                            <td>{!! $sale->created_at->diffForHumans() !!}</td>
                                                            <td><a href="{{ url('admin/sales', ['$id' => $sale->id]) }}"
                                                                    class="showbtn" target="_blank"
                                                                    title="Imprimer facture"><button
                                                                        class="btn btn-success btn-sm"><i
                                                                            class="fa fa-print"
                                                                            aria-hidden="true"></i></button></a></td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>