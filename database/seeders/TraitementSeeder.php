<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Traitement;

class TraitementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $traitements = [
            // Left
            ['RADIO', 'Z04', 'Radio rétro alvéolaire'],
            ['RADIO', 'Z14', 'Bilan complet de radiographie intra oral'],
            ['RADIO', 'Z02', 'Test vitalité'],

            ['PARADONTOLOGIE', 'D24', 'Détartrage complet sus et sous gingival (2 seances)'],
            ['PARADONTOLOGIE', 'D10', 'Prophylaxie enfant'],
            ['PARADONTOLOGIE', 'D10', 'Application topique de fluor'],
            ['PARADONTOLOGIE', 'D10', 'Séalants (par dent)'],
            ['PARADONTOLOGIE', 'D05', 'Séalants (après la 1re dent)'],
            ['PARADONTOLOGIE', 'D40', 'Attelles métalliques dans les paradontopathies'],
            ['PARADONTOLOGIE', 'D12', 'Ligature métallique dans les paradontopathies'],
            ['PARADONTOLOGIE', 'D70', 'Prothèse atteles de contention'],
            ['PARADONTOLOGIE', 'D20', 'Curetage gingival'],
            ['PARADONTOLOGIE', 'D25', 'Electrochirugie / dent'],
            ['PARADONTOLOGIE', 'D20', 'Gingivectomie / gingivoplastie'],
            ['PARADONTOLOGIE', 'D20', 'Plan de détartrage des racines / quadran'],
            ['PARADONTOLOGIE', 'D20', 'Greffe gingevo-péridontale'],

            ['AMALGAME', 'D05', 'Plombage provisoire'],
            ['AMALGAME', 'D12', 'Plombage amalgame 1 à 2 faces / line'],
            ['AMALGAME', 'D18', 'Plombage amalgame 3 faces'],
            ['AMALGAME', 'D20', 'Plombage amalgame plus 3 faces'],
            ['AMALGAME', 'D05', 'Dycal Iner'],
            ['AMALGAME', 'D10', 'Screw-post'],

            ['COMPOSITE', 'SC12', 'Composite antérieure classe III / V'],
            ['COMPOSITE', 'SC12', 'Composite antérieure classe IV'],
            ['COMPOSITE', 'SC20', 'Composite antérieure comb III / IV / V'],
            ['COMPOSITE', 'SC20', 'Composite postérieure 1 surface'],
            ['COMPOSITE', 'D05', 'Dycal liner'],

            ['ENDODONTIE', 'D10', 'Pulpectomie'],
            ['ENDODONTIE', 'D15', 'Pulpectomie incisivo-canin'],
            ['ENDODONTIE', 'D15', 'Pulpectomie prémolaire'],
            ['ENDODONTIE', 'D25', 'Pulpectomie molaire'],
            ['ENDODONTIE', 'D50', 'Dévitalisation 04 canals'],
            ['ENDODONTIE', 'D50', 'Apisectomie'],
            
            ['IMPLANTOLOGIE ORAL', null, 'Implantologie unitaire'],
            ['IMPLANTOLOGIE ORAL', null, 'Implantologie apres le 1er implant'],

            // Right
            ['CIMENT VERRE IONOMETRE', '14400', 'Plombage ciment verre ionomère'],

            ['CHIRURGIE', 'D10', 'Extraction simple'],
            ['CHIRURGIE', 'D20', 'Extraction de l\'apex'],
            ['CHIRURGIE', 'D30', 'Extraction chirugicale (tissus mous)'],
            ['CHIRURGIE', 'D40', 'Extraction chirugicale complexe'],
            ['CHIRURGIE', 'D08', 'Extraction dent lactéale'],
            ['CHIRURGIE', 'D50', 'Extraction dent incluse'],
            ['CHIRURGIE', 'D50', 'Extr. dent en désinc. dont la couronne est sous muqueuse en pos. palatine / linguale'],
            ['CHIRURGIE', 'D15', 'Alvéoplastie'],
            ['CHIRURGIE', 'D80', 'Dent ectopique et incluse'],
            ['CHIRURGIE', 'D40', 'Germectomie dent de sagesse'],
            ['CHIRURGIE', 'D25', 'Germectomie autre dent'],
            ['CHIRURGIE', 'D20', 'Frénectomie'],

            ['PROTHESE FIXEE', '50000', 'Couronne provisoire (seul)'],
            ['PROTHESE FIXEE', '180000', 'Couronne coule unitaire en métallique'],
            ['PROTHESE FIXEE', '250000', 'Couronne unitaire céramo-métallique (dentiste)'],
            ['PROTHESE FIXEE', '300000', 'Bridge métallique'],
            ['PROTHESE FIXEE', '450000', 'Bridge céramo-métallique'],
            ['PROTHESE FIXEE', '75000', 'Pivot coule'],
            ['PROTHESE FIXEE', '12000', 'Recimentation couronne'],

            ['PROTHESE ADJOINTE PARTIELLE (SCP)', '36000', 'Prothèse adjointe partielle 01 dent'],
            ['PROTHESE ADJOINTE PARTIELLE (SCP)', '51000', 'Prothèse adjointe partielle 02 dents'],
            ['PROTHESE ADJOINTE PARTIELLE (SCP)', '60000', 'Prothèse adjointe partielle 03 dents'],
            ['PROTHESE ADJOINTE PARTIELLE (SCP)', '66000', 'Prothèse adjointe partielle 04 dents'],
            ['PROTHESE ADJOINTE PARTIELLE (SCP)', '78000', 'Prothèse adjointe partielle 05 dents (dentiste)'],
            ['PROTHESE ADJOINTE PARTIELLE (SCP)', '87000', 'Prothèse adjointe partielle 06 dents (dentiste)'],
            ['PROTHESE ADJOINTE PARTIELLE (SCP)', '96000', 'Prothèse adjointe partielle 07 dents (dentiste)'],
            ['PROTHESE ADJOINTE PARTIELLE (SCP)', '105000', 'Prothèse adjointe partielle 08 dents (dentiste)'],
            ['PROTHESE ADJOINTE PARTIELLE (SCP)', '120000', 'Prothèse adjointe partielle 09 dents (dentiste)'],
            ['PROTHESE ADJOINTE PARTIELLE (SCP)', '128000', 'Prothèse adjointe partielle 10 dents (dentiste)'],
            ['PROTHESE ADJOINTE PARTIELLE (SCP)', '140000', 'Prothèse adjointe partielle 11 dents (dentiste)'],
            ['PROTHESE ADJOINTE PARTIELLE (SCP)', '151000', 'Prothèse adjointe partielle 12 dents (dentiste)'],
            ['PROTHESE ADJOINTE PARTIELLE (SCP)', '185000', 'Prothèse adjointe partielle 13 dents (dentiste)'],
            ['PROTHESE ADJOINTE PARTIELLE (SCP)', '211000', 'Prothèse adjointe partielle 14 dents (dentiste)'],
            ['PROTHESE ADJOINTE PARTIELLE (SCP)', '15000', 'Modèle d\'étude (dentiste)'],
            ['PROTHESE ADJOINTE PARTIELLE (SCP)', '500000', 'Cadre métallique'],
            ['PROTHESE ADJOINTE PARTIELLE (SCP)', '24000', 'Réparation dentier sans dent'],
            ['PROTHESE ADJOINTE PARTIELLE (SCP)', '12000', 'Réparation dentier avec dent / dent'],
            ['PROTHESE ADJOINTE PARTIELLE (SCP)', '12000', 'Supplément de dent sur dentier / dent'],
            ['PROTHESE ADJOINTE PARTIELLE (SCP)', '75000', 'Gouttière (dentiste)'],
        ];

        foreach($traitements as $traitement)
        {
            Traitement::create([
                'type' => $traitement[0],
                'code' => $traitement[1],
                'designation' => $traitement[2],
            ]);
        }
    }
}
