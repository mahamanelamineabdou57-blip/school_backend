<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Historique de Paiements — {{ $etudiant->nom }} {{ $etudiant->prenom }}</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 11px;
            color: #1a1a2e;
            background: #fff;
        }

        /* ── En-tête ── */
        .header {
            background: linear-gradient(135deg, #1a1a2e 0%, #16213e 60%, #0f3460 100%);
            color: #fff;
            padding: 24px 30px;
            margin-bottom: 24px;
        }
        .header-top {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
        }
        .school-name {
            font-size: 18px;
            font-weight: bold;
            letter-spacing: 1px;
            text-transform: uppercase;
        }
        .school-sub {
            font-size: 10px;
            color: #a8b2d8;
            margin-top: 2px;
        }
        .doc-title {
            text-align: right;
        }
        .doc-title h2 {
            font-size: 14px;
            font-weight: bold;
            color: #e94560;
            text-transform: uppercase;
            letter-spacing: 2px;
        }
        .doc-title p {
            font-size: 9px;
            color: #a8b2d8;
            margin-top: 3px;
        }
        .header-divider {
            border-top: 1px solid rgba(255,255,255,0.15);
            margin: 14px 0;
        }
        .header-bottom {
            display: flex;
            justify-content: space-between;
            font-size: 10px;
            color: #c8d0e8;
        }

        /* ── Fiche étudiant ── */
        .student-card {
            background: #f8f9fe;
            border: 1px solid #e2e8f0;
            border-left: 4px solid #0f3460;
            border-radius: 6px;
            padding: 14px 20px;
            margin: 0 30px 20px;
        }
        .student-card h3 {
            font-size: 13px;
            color: #0f3460;
            margin-bottom: 8px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .student-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 8px;
        }
        .student-field label {
            font-size: 9px;
            color: #718096;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .student-field p {
            font-size: 11px;
            font-weight: bold;
            color: #2d3748;
        }

        /* ── Résumé financier ── */
        .summary {
            margin: 0 30px 20px;
            display: flex;
            gap: 12px;
        }
        .summary-box {
            flex: 1;
            border-radius: 6px;
            padding: 12px 16px;
            text-align: center;
        }
        .summary-box.total-du {
            background: #fff5f5;
            border: 1px solid #feb2b2;
        }
        .summary-box.total-verse {
            background: #f0fff4;
            border: 1px solid #9ae6b4;
        }
        .summary-box.solde {
            background: #fffaf0;
            border: 1px solid #fbd38d;
        }
        .summary-box .amount {
            font-size: 16px;
            font-weight: bold;
            margin-bottom: 2px;
        }
        .summary-box.total-du .amount   { color: #c53030; }
        .summary-box.total-verse .amount { color: #276749; }
        .summary-box.solde .amount       { color: #c05621; }
        .summary-box .label {
            font-size: 9px;
            color: #718096;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        /* ── Tableau des frais ── */
        .section-title {
            margin: 0 30px 10px;
            font-size: 12px;
            font-weight: bold;
            color: #0f3460;
            text-transform: uppercase;
            letter-spacing: 1px;
            padding-bottom: 6px;
            border-bottom: 2px solid #0f3460;
        }

        .fees-table {
            width: calc(100% - 60px);
            margin: 0 30px 20px;
            border-collapse: collapse;
            font-size: 10px;
        }
        .fees-table th {
            background: #0f3460;
            color: #fff;
            padding: 8px 10px;
            text-align: left;
            font-size: 9px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .fees-table td {
            padding: 7px 10px;
            border-bottom: 1px solid #e2e8f0;
            vertical-align: top;
        }
        .fees-table tr:nth-child(even) td {
            background: #f8f9fe;
        }
        .badge {
            display: inline-block;
            padding: 2px 7px;
            border-radius: 10px;
            font-size: 9px;
            font-weight: bold;
            text-transform: uppercase;
        }
        .badge-paid    { background: #c6f6d5; color: #276749; }
        .badge-partial { background: #fef3c7; color: #92400e; }
        .badge-pending { background: #fed7d7; color: #c53030; }

        /* ── Transactions ── */
        .transactions-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 9px;
            margin-top: 4px;
            background: #fff;
        }
        .transactions-table th {
            background: #e2e8f0;
            color: #4a5568;
            padding: 4px 8px;
            text-align: left;
        }
        .transactions-table td {
            padding: 4px 8px;
            border-bottom: 1px solid #edf2f7;
            color: #4a5568;
        }
        .no-transactions {
            color: #a0aec0;
            font-style: italic;
            font-size: 9px;
        }

        /* ── Pied de page ── */
        .footer {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            background: #f8f9fe;
            border-top: 2px solid #0f3460;
            padding: 8px 30px;
            display: flex;
            justify-content: space-between;
            font-size: 9px;
            color: #718096;
        }
        .footer .generated {
            color: #a0aec0;
        }
    </style>
</head>
<body>

    {{-- En-tête --}}
    <div class="header">
        <div class="header-top">
            <div>
                <div class="school-name">École Supérieure</div>
                <div class="school-sub">Système de Gestion Académique</div>
            </div>
            <div class="doc-title">
                <h2>Historique de Paiements</h2>
                <p>Document officiel — Confidentiel</p>
            </div>
        </div>
        <div class="header-divider"></div>
        <div class="header-bottom">
            <span>Date d'édition : {{ now()->format('d/m/Y à H:i') }}</span>
            <span>Réf. : HP-{{ str_pad($etudiant->id, 6, '0', STR_PAD_LEFT) }}-{{ now()->format('Ymd') }}</span>
        </div>
    </div>

    {{-- Fiche étudiant --}}
    <div class="student-card">
        <h3>Informations de l'étudiant</h3>
        <div class="student-grid">
            <div class="student-field">
                <label>Matricule</label>
                <p>{{ $etudiant->matricule }}</p>
            </div>
            <div class="student-field">
                <label>Nom complet</label>
                <p>{{ $etudiant->prenom }} {{ $etudiant->nom }}</p>
            </div>
            <div class="student-field">
                <label>Email</label>
                <p>{{ $etudiant->email ?? '—' }}</p>
            </div>
            <div class="student-field">
                <label>Filière / Formation</label>
                <p>{{ optional(optional($inscription)->formation)->nom ?? '—' }}</p>
            </div>
            <div class="student-field">
                <label>Semestre courant</label>
                <p>
                    @if(optional($inscription)->semestre_courant)
                        Semestre {{ $inscription->semestre_courant }}
                    @else
                        —
                    @endif
                </p>
            </div>
            <div class="student-field">
                <label>Année scolaire</label>
                <p>{{ optional(optional($inscription)->academicYear)->nom ?? '—' }}</p>
            </div>
        </div>
    </div>

    {{-- Résumé financier --}}
    <div class="summary">
        <div class="summary-box total-du">
            <div class="amount">{{ number_format($totalDu, 0, ',', ' ') }} FCFA</div>
            <div class="label">Total dû</div>
        </div>
        <div class="summary-box total-verse">
            <div class="amount">{{ number_format($totalVerse, 0, ',', ' ') }} FCFA</div>
            <div class="label">Total versé</div>
        </div>
        <div class="summary-box solde">
            <div class="amount">{{ number_format($solde, 0, ',', ' ') }} FCFA</div>
            <div class="label">Solde restant</div>
        </div>
    </div>

    {{-- Détail des frais et transactions --}}
    <div class="section-title">Détail des frais</div>

    <table class="fees-table">
        <thead>
            <tr>
                <th>#</th>
                <th>Type de frais</th>
                <th>Montant total</th>
                <th>Versé</th>
                <th>Statut</th>
                <th>Transactions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($etudiant->studentFees as $i => $sf)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td>
                        <strong>{{ ucfirst(optional($sf->fee)->type ?? '—') }}</strong>
                    </td>
                    <td><strong>{{ number_format(optional($sf->fee)->montant ?? 0, 0, ',', ' ') }} FCFA</strong></td>
                    <td>{{ number_format($sf->paid_amount, 0, ',', ' ') }} FCFA</td>
                    <td>
                        @if($sf->status === 'paid')
                            <span class="badge badge-paid">Payé</span>
                        @elseif($sf->status === 'partial')
                            <span class="badge badge-partial">Partiel</span>
                        @else
                            <span class="badge badge-pending">Non payé</span>
                        @endif
                    </td>
                    <td>
                        @if($sf->paymentHistories->isNotEmpty())
                            <table class="transactions-table">
                                <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>Montant</th>
                                        <th>Mode</th>
                                        <th>Réf.</th>
                                        <th>Agent</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($sf->paymentHistories as $ph)
                                        <tr>
                                            <td>{{ $ph->created_at?->format('d/m/Y') }}</td>
                                            <td><strong>{{ number_format($ph->montant_verse, 0, ',', ' ') }} FCFA</strong></td>
                                            <td>{{ ucfirst($ph->mode_paiement) }}</td>
                                            <td>{{ $ph->reference ?? '—' }}</td>
                                            <td>{{ optional($ph->enregistrePar)->name ?? '—' }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @else
                            <span class="no-transactions">Aucune transaction enregistrée</span>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" style="text-align:center; color:#a0aec0; padding:20px;">
                        Aucun frais enregistré pour cet étudiant.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    {{-- Pied de page --}}
    <div class="footer">
        <span>{{ $etudiant->prenom }} {{ $etudiant->nom }} — {{ $etudiant->matricule }}</span>
        <span class="generated">Généré le {{ now()->format('d/m/Y à H:i:s') }}</span>
    </div>

</body>
</html>
