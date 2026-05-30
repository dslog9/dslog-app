<?php

namespace Database\Seeders;

use App\Models\Marker;
use App\Models\MarkerProfileApplicability;
use App\Models\MarkerScoringProfile;
use Illuminate\Database\Seeder;

class MarkerProfileApplicabilitySeeder extends Seeder
{
    public function run(): void
    {
        $profiles = MarkerScoringProfile::all()
            ->keyBy('slug');

        $matrix = [

            'hemoglobin' => [
                'general-adult' => [
                    'status' => 'applicable',
                    'primary' => true,
                    'priority' => 10,
                    'reason' => 'Base fallback profile',
                ],

                'male-adult' => [
                    'status' => 'applicable',
                    'priority' => 20,
                    'reason' => 'Male hemoglobin ranges differ',
                ],

                'female-adult' => [
                    'status' => 'applicable',
                    'priority' => 30,
                    'reason' => 'Female hemoglobin ranges differ',
                ],

                'female-pregnant' => [
                    'status' => 'applicable',
                    'priority' => 40,
                    'reason' => 'Pregnancy changes interpretation',
                ],

                'iron-deficiency-risk' => [
                    'status' => 'applicable',
                    'priority' => 50,
                    'reason' => 'Important anemia-related profile',
                ],
            ],

            'ferritin' => [
                'general-adult' => [
                    'status' => 'applicable',
                    'primary' => true,
                    'priority' => 10,
                    'reason' => 'Base fallback profile',
                ],

                'male-adult' => [
                    'status' => 'applicable',
                    'priority' => 20,
                    'reason' => 'Male ferritin ranges differ',
                ],

                'female-adult' => [
                    'status' => 'applicable',
                    'priority' => 30,
                    'reason' => 'Female ferritin ranges differ',
                ],

                'female-pregnant' => [
                    'status' => 'applicable',
                    'priority' => 40,
                    'reason' => 'Pregnancy strongly affects ferritin',
                ],

                'female-postmenopause' => [
                    'status' => 'applicable',
                    'priority' => 50,
                    'reason' => 'Postmenopause changes iron balance',
                ],

                'iron-deficiency-risk' => [
                    'status' => 'applicable',
                    'priority' => 60,
                    'reason' => 'Key iron deficiency profile',
                ],
            ],

            'hdl' => [
                'general-adult' => [
                    'status' => 'applicable',
                    'primary' => true,
                    'priority' => 10,
                    'reason' => 'Base fallback profile',
                ],

                'male-adult' => [
                    'status' => 'applicable',
                    'priority' => 20,
                    'reason' => 'Male HDL differs',
                ],

                'female-adult' => [
                    'status' => 'applicable',
                    'priority' => 30,
                    'reason' => 'Female HDL differs',
                ],

                'cardiovascular-risk' => [
                    'status' => 'applicable',
                    'priority' => 40,
                    'reason' => 'Important cardiovascular marker',
                ],
            ],

            'crp' => [
                'general-adult' => [
                    'status' => 'applicable',
                    'primary' => true,
                    'priority' => 10,
                    'reason' => 'Base fallback profile',
                ],

                'cardiovascular-risk' => [
                    'status' => 'applicable',
                    'priority' => 20,
                    'reason' => 'Inflammation and cardiovascular risk',
                ],

                'insulin-resistance' => [
                    'status' => 'applicable',
                    'priority' => 30,
                    'reason' => 'Inflammation and metabolic syndrome',
                ],
            ],

            'glucose' => [
                'general-adult' => [
                    'status' => 'applicable',
                    'primary' => true,
                    'priority' => 10,
                    'reason' => 'Base glucose scoring profile',
                ],

                'insulin-resistance' => [
                    'status' => 'applicable',
                    'priority' => 20,
                    'reason' => 'Key marker for insulin resistance risk',
                ],

                'cardiovascular-risk' => [
                    'status' => 'applicable',
                    'priority' => 30,
                    'reason' => 'Glucose metabolism affects cardiovascular risk',
                ],

                'female-pregnant' => [
                    'status' => 'applicable',
                    'priority' => 40,
                    'reason' => 'Pregnancy requires separate glucose interpretation',
                ],
            ],

            'hba1c' => [
                'general-adult' => [
                    'status' => 'applicable',
                    'primary' => true,
                    'priority' => 10,
                    'reason' => 'Base HbA1c scoring profile',
                ],

                'insulin-resistance' => [
                    'status' => 'applicable',
                    'priority' => 20,
                    'reason' => 'Key long-term glucose metabolism marker',
                ],

                'cardiovascular-risk' => [
                    'status' => 'applicable',
                    'priority' => 30,
                    'reason' => 'HbA1c is relevant for cardiometabolic risk',
                ],
            ],

            'vitamin-d' => [
                'general-adult' => [
                    'status' => 'applicable',
                    'primary' => true,
                    'priority' => 10,
                    'reason' => 'Base vitamin D scoring profile',
                ],

                'female-pregnant' => [
                    'status' => 'applicable',
                    'priority' => 20,
                    'reason' => 'Pregnancy changes vitamin D relevance',
                ],

                'senior' => [
                    'status' => 'applicable',
                    'priority' => 30,
                    'reason' => 'Older adults have higher deficiency relevance',
                ],
            ],

            'tsh' => [
                'general-adult' => [
                    'status' => 'applicable',
                    'primary' => true,
                    'priority' => 10,
                    'reason' => 'Base thyroid scoring profile',
                ],

                'female-adult' => [
                    'status' => 'applicable',
                    'priority' => 20,
                    'reason' => 'Thyroid interpretation is especially relevant for women',
                ],

                'female-pregnant' => [
                    'status' => 'applicable',
                    'priority' => 30,
                    'reason' => 'Pregnancy requires separate thyroid interpretation',
                ],

                'thyroid-risk' => [
                    'status' => 'applicable',
                    'priority' => 40,
                    'reason' => 'Core marker for thyroid risk profile',
                ],

                'senior' => [
                    'status' => 'applicable',
                    'priority' => 50,
                    'reason' => 'TSH interpretation may differ in older adults',
                ],
            ],

        /*
        |--------------------------------------------------------------------------
        | Paste these entries inside the existing $matrix = [ ... ]; array.
        | Do not paste the PHP opening tag or return wrapper.
        |--------------------------------------------------------------------------
        */

            'esr' => [
                'general-adult' => [
                    'status' => 'applicable',
                    'primary' => true,
                    'priority' => 10,
                    'reason' => 'Base adult interpretation profile',
                ],

                'female-adult' => [
                    'status' => 'applicable',
                    'priority' => 20,
                    'reason' => 'ESR reference interpretation differs by sex',
                ],

                'female-pregnant' => [
                    'status' => 'applicable',
                    'priority' => 30,
                    'reason' => 'Pregnancy can physiologically change ESR',
                ],

                'senior' => [
                    'status' => 'applicable',
                    'priority' => 40,
                    'reason' => 'ESR interpretation changes with age',
                ],

                'child' => [
                    'status' => 'applicable',
                    'priority' => 50,
                    'reason' => 'Pediatric ESR interpretation differs',
                ],

                'teen' => [
                    'status' => 'applicable',
                    'priority' => 60,
                    'reason' => 'Teen ESR interpretation differs',
                ],

                'cardiovascular-risk' => [
                    'status' => 'applicable',
                    'priority' => 70,
                    'reason' => 'Inflammation is relevant to cardiovascular risk',
                ],

            ],

            'uric-acid' => [
                'general-adult' => [
                    'status' => 'applicable',
                    'primary' => true,
                    'priority' => 10,
                    'reason' => 'Base adult interpretation profile',
                ],

                'male-adult' => [
                    'status' => 'applicable',
                    'priority' => 20,
                    'reason' => 'Uric acid reference ranges differ by sex',
                ],

                'female-adult' => [
                    'status' => 'applicable',
                    'priority' => 30,
                    'reason' => 'Uric acid reference ranges differ by sex',
                ],

                'female-postmenopause' => [
                    'status' => 'applicable',
                    'priority' => 40,
                    'reason' => 'Postmenopause changes uric acid and cardiometabolic context',
                ],

                'senior' => [
                    'status' => 'applicable',
                    'priority' => 50,
                    'reason' => 'Uric acid interpretation changes with age and renal function',
                ],

                'cardiovascular-risk' => [
                    'status' => 'applicable',
                    'priority' => 60,
                    'reason' => 'Uric acid is relevant to cardiovascular and renal risk',
                ],

                'insulin-resistance' => [
                    'status' => 'applicable',
                    'priority' => 70,
                    'reason' => 'Uric acid is often linked to insulin resistance/metabolic risk',
                ],

            ],

            'alp' => [
                'general-adult' => [
                    'status' => 'applicable',
                    'primary' => true,
                    'priority' => 10,
                    'reason' => 'Base adult interpretation profile',
                ],

                'female-pregnant' => [
                    'status' => 'applicable',
                    'priority' => 20,
                    'reason' => 'Pregnancy can physiologically increase alkaline phosphatase',
                ],

                'child' => [
                    'status' => 'applicable',
                    'priority' => 30,
                    'reason' => 'Pediatric/bone growth context changes ALP',
                ],

                'teen' => [
                    'status' => 'applicable',
                    'priority' => 40,
                    'reason' => 'Teen/bone growth context changes ALP',
                ],

                'senior' => [
                    'status' => 'applicable',
                    'priority' => 50,
                    'reason' => 'Bone/liver interpretation changes with age',
                ],

            ],

            'calcium' => [
                'general-adult' => [
                    'status' => 'applicable',
                    'primary' => true,
                    'priority' => 10,
                    'reason' => 'Base adult interpretation profile',
                ],

                'female-pregnant' => [
                    'status' => 'applicable',
                    'priority' => 20,
                    'reason' => 'Pregnancy changes calcium interpretation',
                ],

                'female-postmenopause' => [
                    'status' => 'applicable',
                    'priority' => 30,
                    'reason' => 'Bone/mineral context changes after menopause',
                ],

                'senior' => [
                    'status' => 'applicable',
                    'priority' => 40,
                    'reason' => 'Calcium interpretation is age-context dependent',
                ],

                'child' => [
                    'status' => 'applicable',
                    'priority' => 50,
                    'reason' => 'Pediatric calcium ranges differ',
                ],

                'teen' => [
                    'status' => 'applicable',
                    'priority' => 60,
                    'reason' => 'Teen calcium ranges differ',
                ],

            ],

            'insulin' => [
                'general-adult' => [
                    'status' => 'applicable',
                    'primary' => true,
                    'priority' => 10,
                    'reason' => 'Base adult interpretation profile',
                ],

                'insulin-resistance' => [
                    'status' => 'applicable',
                    'priority' => 20,
                    'reason' => 'Core insulin resistance marker',
                ],

                'cardiovascular-risk' => [
                    'status' => 'applicable',
                    'priority' => 30,
                    'reason' => 'Hyperinsulinemia is relevant to cardiometabolic risk',
                ],

                'female-pregnant' => [
                    'status' => 'applicable',
                    'priority' => 40,
                    'reason' => 'Pregnancy can change insulin/glucose interpretation',
                ],

            ],

            'inr' => [
                'general-adult' => [
                    'status' => 'applicable',
                    'primary' => true,
                    'priority' => 10,
                    'reason' => 'Base adult interpretation profile',
                ],

                'female-pregnant' => [
                    'status' => 'applicable',
                    'priority' => 20,
                    'reason' => 'Pregnancy changes coagulation interpretation',
                ],

                'senior' => [
                    'status' => 'applicable',
                    'priority' => 30,
                    'reason' => 'Thrombosis/bleeding risk interpretation changes with age',
                ],

                'cardiovascular-risk' => [
                    'status' => 'applicable',
                    'priority' => 40,
                    'reason' => 'Coagulation markers are relevant to thrombotic cardiovascular risk',
                ],

            ],

            'pt' => [
                'general-adult' => [
                    'status' => 'applicable',
                    'primary' => true,
                    'priority' => 10,
                    'reason' => 'Base adult interpretation profile',
                ],

                'female-pregnant' => [
                    'status' => 'applicable',
                    'priority' => 20,
                    'reason' => 'Pregnancy changes coagulation interpretation',
                ],

                'senior' => [
                    'status' => 'applicable',
                    'priority' => 30,
                    'reason' => 'Thrombosis/bleeding risk interpretation changes with age',
                ],

                'cardiovascular-risk' => [
                    'status' => 'applicable',
                    'priority' => 40,
                    'reason' => 'Coagulation markers are relevant to thrombotic cardiovascular risk',
                ],

            ],

            'aptt' => [
                'general-adult' => [
                    'status' => 'applicable',
                    'primary' => true,
                    'priority' => 10,
                    'reason' => 'Base adult interpretation profile',
                ],

                'female-pregnant' => [
                    'status' => 'applicable',
                    'priority' => 20,
                    'reason' => 'Pregnancy changes coagulation interpretation',
                ],

                'senior' => [
                    'status' => 'applicable',
                    'priority' => 30,
                    'reason' => 'Thrombosis/bleeding risk interpretation changes with age',
                ],

                'cardiovascular-risk' => [
                    'status' => 'applicable',
                    'priority' => 40,
                    'reason' => 'Coagulation markers are relevant to thrombotic cardiovascular risk',
                ],

            ],

            'fibrinogen' => [
                'general-adult' => [
                    'status' => 'applicable',
                    'primary' => true,
                    'priority' => 10,
                    'reason' => 'Base adult interpretation profile',
                ],

                'female-pregnant' => [
                    'status' => 'applicable',
                    'priority' => 20,
                    'reason' => 'Pregnancy changes coagulation interpretation',
                ],

                'senior' => [
                    'status' => 'applicable',
                    'priority' => 30,
                    'reason' => 'Thrombosis/bleeding risk interpretation changes with age',
                ],

                'cardiovascular-risk' => [
                    'status' => 'applicable',
                    'priority' => 40,
                    'reason' => 'Coagulation markers are relevant to thrombotic cardiovascular risk',
                ],

            ],

            'mpv' => [
                'general-adult' => [
                    'status' => 'applicable',
                    'primary' => true,
                    'priority' => 10,
                    'reason' => 'Base adult interpretation profile',
                ],

                'child' => [
                    'status' => 'applicable',
                    'priority' => 20,
                    'reason' => 'Pediatric platelet index interpretation differs',
                ],

                'teen' => [
                    'status' => 'applicable',
                    'priority' => 30,
                    'reason' => 'Teen platelet index interpretation differs',
                ],

                'senior' => [
                    'status' => 'applicable',
                    'priority' => 40,
                    'reason' => 'Platelet indices can be age-context dependent',
                ],

            ],

            'plateletcrit' => [
                'general-adult' => [
                    'status' => 'applicable',
                    'primary' => true,
                    'priority' => 10,
                    'reason' => 'Base adult interpretation profile',
                ],

                'child' => [
                    'status' => 'applicable',
                    'priority' => 20,
                    'reason' => 'Pediatric platelet index interpretation differs',
                ],

                'teen' => [
                    'status' => 'applicable',
                    'priority' => 30,
                    'reason' => 'Teen platelet index interpretation differs',
                ],

                'senior' => [
                    'status' => 'applicable',
                    'priority' => 40,
                    'reason' => 'Platelet indices can be age-context dependent',
                ],

            ],

            'pdw' => [
                'general-adult' => [
                    'status' => 'applicable',
                    'primary' => true,
                    'priority' => 10,
                    'reason' => 'Base adult interpretation profile',
                ],

                'child' => [
                    'status' => 'applicable',
                    'priority' => 20,
                    'reason' => 'Pediatric platelet index interpretation differs',
                ],

                'teen' => [
                    'status' => 'applicable',
                    'priority' => 30,
                    'reason' => 'Teen platelet index interpretation differs',
                ],

                'senior' => [
                    'status' => 'applicable',
                    'priority' => 40,
                    'reason' => 'Platelet indices can be age-context dependent',
                ],

            ],

            'nucleated-rbc' => [
                'general-adult' => [
                    'status' => 'applicable',
                    'primary' => true,
                    'priority' => 10,
                    'reason' => 'Base adult interpretation profile',
                ],

                'child' => [
                    'status' => 'applicable',
                    'priority' => 20,
                    'reason' => 'Pediatric/ neonatal context can change interpretation',
                ],

                'teen' => [
                    'status' => 'applicable',
                    'priority' => 30,
                    'reason' => 'Teen hematology interpretation differs',
                ],

                'senior' => [
                    'status' => 'applicable',
                    'priority' => 40,
                    'reason' => 'NRBC in adults is clinically significant and age context matters',
                ],

                'iron-deficiency-risk' => [
                    'status' => 'applicable',
                    'priority' => 50,
                    'reason' => 'Anemia context can affect interpretation',
                ],

            ],

            'homa-ir' => [
                'general-adult' => [
                    'status' => 'applicable',
                    'primary' => true,
                    'priority' => 10,
                    'reason' => 'Base adult interpretation profile',
                ],

                'insulin-resistance' => [
                    'status' => 'applicable',
                    'priority' => 20,
                    'reason' => 'Primary profile for insulin resistance calculation',
                ],

                'cardiovascular-risk' => [
                    'status' => 'applicable',
                    'priority' => 30,
                    'reason' => 'Insulin resistance is relevant to cardiometabolic risk',
                ],

                'female-pregnant' => [
                    'status' => 'applicable',
                    'priority' => 40,
                    'reason' => 'Pregnancy requires separate glucose-insulin interpretation',
                ],

            ],

            'globulin' => [
                'general-adult' => [
                    'status' => 'applicable',
                    'primary' => true,
                    'priority' => 10,
                    'reason' => 'Base adult interpretation profile',
                ],

                'female-pregnant' => [
                    'status' => 'applicable',
                    'priority' => 20,
                    'reason' => 'Pregnancy can alter protein fractions',
                ],

                'senior' => [
                    'status' => 'applicable',
                    'priority' => 30,
                    'reason' => 'Protein fraction interpretation can change with age',
                ],

                'child' => [
                    'status' => 'applicable',
                    'priority' => 40,
                    'reason' => 'Pediatric protein fraction interpretation differs',
                ],

                'teen' => [
                    'status' => 'applicable',
                    'priority' => 50,
                    'reason' => 'Teen protein fraction interpretation differs',
                ],

            ],

            'albumin-globulin-ratio' => [
                'general-adult' => [
                    'status' => 'applicable',
                    'primary' => true,
                    'priority' => 10,
                    'reason' => 'Base adult interpretation profile',
                ],

                'female-pregnant' => [
                    'status' => 'applicable',
                    'priority' => 20,
                    'reason' => 'Pregnancy can alter protein fractions',
                ],

                'senior' => [
                    'status' => 'applicable',
                    'priority' => 30,
                    'reason' => 'Protein fraction interpretation can change with age',
                ],

                'child' => [
                    'status' => 'applicable',
                    'priority' => 40,
                    'reason' => 'Pediatric protein fraction interpretation differs',
                ],

                'teen' => [
                    'status' => 'applicable',
                    'priority' => 50,
                    'reason' => 'Teen protein fraction interpretation differs',
                ],

            ],

            'cystatin-c' => [
                'general-adult' => [
                    'status' => 'applicable',
                    'primary' => true,
                    'priority' => 10,
                    'reason' => 'Base adult interpretation profile',
                ],

                'senior' => [
                    'status' => 'applicable',
                    'priority' => 20,
                    'reason' => 'Kidney function interpretation is age-context dependent',
                ],

                'child' => [
                    'status' => 'applicable',
                    'priority' => 30,
                    'reason' => 'Pediatric kidney function interpretation differs',
                ],

                'teen' => [
                    'status' => 'applicable',
                    'priority' => 40,
                    'reason' => 'Teen kidney function interpretation differs',
                ],

                'cardiovascular-risk' => [
                    'status' => 'applicable',
                    'priority' => 50,
                    'reason' => 'Kidney function is relevant to cardiovascular risk',
                ],

            ],

            'bun' => [
                'general-adult' => [
                    'status' => 'applicable',
                    'primary' => true,
                    'priority' => 10,
                    'reason' => 'Base adult interpretation profile',
                ],

                'senior' => [
                    'status' => 'applicable',
                    'priority' => 20,
                    'reason' => 'Renal/hydration interpretation changes with age',
                ],

                'child' => [
                    'status' => 'applicable',
                    'priority' => 30,
                    'reason' => 'Pediatric BUN ranges differ',
                ],

                'teen' => [
                    'status' => 'applicable',
                    'priority' => 40,
                    'reason' => 'Teen BUN ranges differ',
                ],

                'cardiovascular-risk' => [
                    'status' => 'applicable',
                    'priority' => 50,
                    'reason' => 'Renal function contributes to cardiovascular risk',
                ],

            ],

            'calcium-ionized' => [
                'general-adult' => [
                    'status' => 'applicable',
                    'primary' => true,
                    'priority' => 10,
                    'reason' => 'Base adult interpretation profile',
                ],

                'female-pregnant' => [
                    'status' => 'applicable',
                    'priority' => 20,
                    'reason' => 'Pregnancy changes calcium interpretation',
                ],

                'female-postmenopause' => [
                    'status' => 'applicable',
                    'priority' => 30,
                    'reason' => 'Bone/mineral context changes after menopause',
                ],

                'senior' => [
                    'status' => 'applicable',
                    'priority' => 40,
                    'reason' => 'Calcium interpretation is age-context dependent',
                ],

                'child' => [
                    'status' => 'applicable',
                    'priority' => 50,
                    'reason' => 'Pediatric calcium ranges differ',
                ],

                'teen' => [
                    'status' => 'applicable',
                    'priority' => 60,
                    'reason' => 'Teen calcium ranges differ',
                ],

            ],

            'bicarbonate' => [
                'general-adult' => [
                    'status' => 'applicable',
                    'primary' => true,
                    'priority' => 10,
                    'reason' => 'Base adult interpretation profile',
                ],

                'senior' => [
                    'status' => 'applicable',
                    'priority' => 20,
                    'reason' => 'Acid-base interpretation can be age/context dependent',
                ],

                'child' => [
                    'status' => 'applicable',
                    'priority' => 30,
                    'reason' => 'Pediatric acid-base ranges differ',
                ],

                'teen' => [
                    'status' => 'applicable',
                    'priority' => 40,
                    'reason' => 'Teen acid-base ranges differ',
                ],

            ],

            'anion-gap' => [
                'general-adult' => [
                    'status' => 'applicable',
                    'primary' => true,
                    'priority' => 10,
                    'reason' => 'Base adult interpretation profile',
                ],

                'senior' => [
                    'status' => 'applicable',
                    'priority' => 20,
                    'reason' => 'Acid-base interpretation can be age/context dependent',
                ],

                'child' => [
                    'status' => 'applicable',
                    'priority' => 30,
                    'reason' => 'Pediatric acid-base ranges differ',
                ],

                'teen' => [
                    'status' => 'applicable',
                    'priority' => 40,
                    'reason' => 'Teen acid-base ranges differ',
                ],

                'insulin-resistance' => [
                    'status' => 'applicable',
                    'priority' => 50,
                    'reason' => 'Anion gap can be relevant in ketoacidosis/metabolic decompensation context',
                ],

            ],

            'osmolality' => [
                'general-adult' => [
                    'status' => 'applicable',
                    'primary' => true,
                    'priority' => 10,
                    'reason' => 'Base adult interpretation profile',
                ],

                'senior' => [
                    'status' => 'applicable',
                    'priority' => 20,
                    'reason' => 'Hydration/osmolality interpretation is age-context dependent',
                ],

                'child' => [
                    'status' => 'applicable',
                    'priority' => 30,
                    'reason' => 'Pediatric osmolality interpretation differs',
                ],

                'teen' => [
                    'status' => 'applicable',
                    'priority' => 40,
                    'reason' => 'Teen osmolality interpretation differs',
                ],

            ],

            'amylase' => [
                'general-adult' => [
                    'status' => 'applicable',
                    'primary' => true,
                    'priority' => 10,
                    'reason' => 'Base adult interpretation profile',
                ],

                'senior' => [
                    'status' => 'applicable',
                    'priority' => 20,
                    'reason' => 'Pancreatic/renal context changes with age',
                ],

                'child' => [
                    'status' => 'applicable',
                    'priority' => 30,
                    'reason' => 'Pediatric enzyme interpretation differs',
                ],

                'teen' => [
                    'status' => 'applicable',
                    'priority' => 40,
                    'reason' => 'Teen enzyme interpretation differs',
                ],

            ],

            'lipase' => [
                'general-adult' => [
                    'status' => 'applicable',
                    'primary' => true,
                    'priority' => 10,
                    'reason' => 'Base adult interpretation profile',
                ],

                'senior' => [
                    'status' => 'applicable',
                    'priority' => 20,
                    'reason' => 'Pancreatic/renal context changes with age',
                ],

                'child' => [
                    'status' => 'applicable',
                    'priority' => 30,
                    'reason' => 'Pediatric enzyme interpretation differs',
                ],

                'teen' => [
                    'status' => 'applicable',
                    'priority' => 40,
                    'reason' => 'Teen enzyme interpretation differs',
                ],

            ],

            'apolipoprotein-a1' => [
                'general-adult' => [
                    'status' => 'applicable',
                    'primary' => true,
                    'priority' => 10,
                    'reason' => 'Base adult interpretation profile',
                ],

                'male-adult' => [
                    'status' => 'applicable',
                    'priority' => 20,
                    'reason' => 'Cardiometabolic interpretation can differ by sex',
                ],

                'female-adult' => [
                    'status' => 'applicable',
                    'priority' => 30,
                    'reason' => 'Cardiometabolic interpretation can differ by sex',
                ],

                'female-postmenopause' => [
                    'status' => 'applicable',
                    'priority' => 40,
                    'reason' => 'Postmenopause changes lipid/cardiovascular risk context',
                ],

                'senior' => [
                    'status' => 'applicable',
                    'priority' => 50,
                    'reason' => 'Age changes absolute cardiovascular risk context',
                ],

                'cardiovascular-risk' => [
                    'status' => 'applicable',
                    'priority' => 60,
                    'reason' => 'Core advanced lipid risk marker',
                ],

                'insulin-resistance' => [
                    'status' => 'applicable',
                    'priority' => 70,
                    'reason' => 'Atherogenic lipid patterns are relevant in insulin resistance',
                ],

            ],

            'apolipoprotein-b' => [
                'general-adult' => [
                    'status' => 'applicable',
                    'primary' => true,
                    'priority' => 10,
                    'reason' => 'Base adult interpretation profile',
                ],

                'male-adult' => [
                    'status' => 'applicable',
                    'priority' => 20,
                    'reason' => 'Cardiometabolic interpretation can differ by sex',
                ],

                'female-adult' => [
                    'status' => 'applicable',
                    'priority' => 30,
                    'reason' => 'Cardiometabolic interpretation can differ by sex',
                ],

                'female-postmenopause' => [
                    'status' => 'applicable',
                    'priority' => 40,
                    'reason' => 'Postmenopause changes lipid/cardiovascular risk context',
                ],

                'senior' => [
                    'status' => 'applicable',
                    'priority' => 50,
                    'reason' => 'Age changes absolute cardiovascular risk context',
                ],

                'cardiovascular-risk' => [
                    'status' => 'applicable',
                    'priority' => 60,
                    'reason' => 'Core advanced lipid risk marker',
                ],

                'insulin-resistance' => [
                    'status' => 'applicable',
                    'priority' => 70,
                    'reason' => 'Atherogenic lipid patterns are relevant in insulin resistance',
                ],

            ],

            'lipoprotein-a' => [
                'general-adult' => [
                    'status' => 'applicable',
                    'primary' => true,
                    'priority' => 10,
                    'reason' => 'Base adult interpretation profile',
                ],

                'male-adult' => [
                    'status' => 'applicable',
                    'priority' => 20,
                    'reason' => 'Cardiometabolic interpretation can differ by sex',
                ],

                'female-adult' => [
                    'status' => 'applicable',
                    'priority' => 30,
                    'reason' => 'Cardiometabolic interpretation can differ by sex',
                ],

                'female-postmenopause' => [
                    'status' => 'applicable',
                    'priority' => 40,
                    'reason' => 'Postmenopause changes lipid/cardiovascular risk context',
                ],

                'senior' => [
                    'status' => 'applicable',
                    'priority' => 50,
                    'reason' => 'Age changes absolute cardiovascular risk context',
                ],

                'cardiovascular-risk' => [
                    'status' => 'applicable',
                    'priority' => 60,
                    'reason' => 'Core advanced lipid risk marker',
                ],

                'insulin-resistance' => [
                    'status' => 'applicable',
                    'priority' => 70,
                    'reason' => 'Atherogenic lipid patterns are relevant in insulin resistance',
                ],

            ],

            'vitamin-b1' => [
                'general-adult' => [
                    'status' => 'applicable',
                    'primary' => true,
                    'priority' => 10,
                    'reason' => 'Base adult interpretation profile',
                ],

                'female-pregnant' => [
                    'status' => 'applicable',
                    'priority' => 20,
                    'reason' => 'Pregnancy changes nutritional requirements and interpretation',
                ],

                'senior' => [
                    'status' => 'applicable',
                    'priority' => 30,
                    'reason' => 'Deficiency/toxicity risk changes with age',
                ],

                'child' => [
                    'status' => 'applicable',
                    'priority' => 40,
                    'reason' => 'Pediatric vitamin requirements differ',
                ],

                'teen' => [
                    'status' => 'applicable',
                    'priority' => 50,
                    'reason' => 'Teen vitamin requirements differ',
                ],

            ],

            'vitamin-b6' => [
                'general-adult' => [
                    'status' => 'applicable',
                    'primary' => true,
                    'priority' => 10,
                    'reason' => 'Base adult interpretation profile',
                ],

                'female-pregnant' => [
                    'status' => 'applicable',
                    'priority' => 20,
                    'reason' => 'Pregnancy changes nutritional requirements and interpretation',
                ],

                'senior' => [
                    'status' => 'applicable',
                    'priority' => 30,
                    'reason' => 'Deficiency/toxicity risk changes with age',
                ],

                'child' => [
                    'status' => 'applicable',
                    'priority' => 40,
                    'reason' => 'Pediatric vitamin requirements differ',
                ],

                'teen' => [
                    'status' => 'applicable',
                    'priority' => 50,
                    'reason' => 'Teen vitamin requirements differ',
                ],

            ],

            'vitamin-a' => [
                'general-adult' => [
                    'status' => 'applicable',
                    'primary' => true,
                    'priority' => 10,
                    'reason' => 'Base adult interpretation profile',
                ],

                'female-pregnant' => [
                    'status' => 'applicable',
                    'priority' => 20,
                    'reason' => 'Pregnancy changes nutritional requirements and interpretation',
                ],

                'senior' => [
                    'status' => 'applicable',
                    'priority' => 30,
                    'reason' => 'Deficiency/toxicity risk changes with age',
                ],

                'child' => [
                    'status' => 'applicable',
                    'priority' => 40,
                    'reason' => 'Pediatric vitamin requirements differ',
                ],

                'teen' => [
                    'status' => 'applicable',
                    'priority' => 50,
                    'reason' => 'Teen vitamin requirements differ',
                ],

            ],

            'vitamin-e' => [
                'general-adult' => [
                    'status' => 'applicable',
                    'primary' => true,
                    'priority' => 10,
                    'reason' => 'Base adult interpretation profile',
                ],

                'female-pregnant' => [
                    'status' => 'applicable',
                    'priority' => 20,
                    'reason' => 'Pregnancy changes nutritional requirements and interpretation',
                ],

                'senior' => [
                    'status' => 'applicable',
                    'priority' => 30,
                    'reason' => 'Deficiency/toxicity risk changes with age',
                ],

                'child' => [
                    'status' => 'applicable',
                    'priority' => 40,
                    'reason' => 'Pediatric vitamin requirements differ',
                ],

                'teen' => [
                    'status' => 'applicable',
                    'priority' => 50,
                    'reason' => 'Teen vitamin requirements differ',
                ],

            ],

            'ceruloplasmin' => [
                'general-adult' => [
                    'status' => 'applicable',
                    'primary' => true,
                    'priority' => 10,
                    'reason' => 'Base adult interpretation profile',
                ],

                'female-pregnant' => [
                    'status' => 'applicable',
                    'priority' => 20,
                    'reason' => 'Pregnancy and estrogen states can increase ceruloplasmin',
                ],

                'child' => [
                    'status' => 'applicable',
                    'priority' => 30,
                    'reason' => 'Pediatric copper metabolism interpretation differs',
                ],

                'teen' => [
                    'status' => 'applicable',
                    'priority' => 40,
                    'reason' => 'Teen copper metabolism interpretation differs',
                ],

            ],

            'thrombin-time' => [
                'general-adult' => [
                    'status' => 'applicable',
                    'primary' => true,
                    'priority' => 10,
                    'reason' => 'Base adult interpretation profile',
                ],

                'female-pregnant' => [
                    'status' => 'applicable',
                    'priority' => 20,
                    'reason' => 'Pregnancy changes coagulation interpretation',
                ],

                'senior' => [
                    'status' => 'applicable',
                    'priority' => 30,
                    'reason' => 'Thrombosis/bleeding risk interpretation changes with age',
                ],

                'cardiovascular-risk' => [
                    'status' => 'applicable',
                    'priority' => 40,
                    'reason' => 'Coagulation markers are relevant to thrombotic cardiovascular risk',
                ],

            ],

            'd-dimer' => [
                'general-adult' => [
                    'status' => 'applicable',
                    'primary' => true,
                    'priority' => 10,
                    'reason' => 'Base adult interpretation profile',
                ],

                'female-pregnant' => [
                    'status' => 'applicable',
                    'priority' => 20,
                    'reason' => 'Pregnancy changes coagulation interpretation',
                ],

                'senior' => [
                    'status' => 'applicable',
                    'priority' => 30,
                    'reason' => 'Thrombosis/bleeding risk interpretation changes with age',
                ],

                'cardiovascular-risk' => [
                    'status' => 'applicable',
                    'priority' => 40,
                    'reason' => 'Coagulation markers are relevant to thrombotic cardiovascular risk',
                ],

            ],

            'antithrombin-iii' => [
                'general-adult' => [
                    'status' => 'applicable',
                    'primary' => true,
                    'priority' => 10,
                    'reason' => 'Base adult interpretation profile',
                ],

                'female-pregnant' => [
                    'status' => 'applicable',
                    'priority' => 20,
                    'reason' => 'Pregnancy changes coagulation interpretation',
                ],

                'senior' => [
                    'status' => 'applicable',
                    'priority' => 30,
                    'reason' => 'Thrombosis/bleeding risk interpretation changes with age',
                ],

                'cardiovascular-risk' => [
                    'status' => 'applicable',
                    'priority' => 40,
                    'reason' => 'Coagulation markers are relevant to thrombotic cardiovascular risk',
                ],

            ],

            'protein-c' => [
                'general-adult' => [
                    'status' => 'applicable',
                    'primary' => true,
                    'priority' => 10,
                    'reason' => 'Base adult interpretation profile',
                ],

                'female-pregnant' => [
                    'status' => 'applicable',
                    'priority' => 20,
                    'reason' => 'Pregnancy changes coagulation interpretation',
                ],

                'senior' => [
                    'status' => 'applicable',
                    'priority' => 30,
                    'reason' => 'Thrombosis/bleeding risk interpretation changes with age',
                ],

                'cardiovascular-risk' => [
                    'status' => 'applicable',
                    'priority' => 40,
                    'reason' => 'Coagulation markers are relevant to thrombotic cardiovascular risk',
                ],

            ],

            'protein-s' => [
                'general-adult' => [
                    'status' => 'applicable',
                    'primary' => true,
                    'priority' => 10,
                    'reason' => 'Base adult interpretation profile',
                ],

                'female-pregnant' => [
                    'status' => 'applicable',
                    'priority' => 20,
                    'reason' => 'Pregnancy changes coagulation interpretation',
                ],

                'senior' => [
                    'status' => 'applicable',
                    'priority' => 30,
                    'reason' => 'Thrombosis/bleeding risk interpretation changes with age',
                ],

                'cardiovascular-risk' => [
                    'status' => 'applicable',
                    'priority' => 40,
                    'reason' => 'Coagulation markers are relevant to thrombotic cardiovascular risk',
                ],

            ],

            'lupus-anticoagulant' => [
                'general-adult' => [
                    'status' => 'applicable',
                    'primary' => true,
                    'priority' => 10,
                    'reason' => 'Base adult interpretation profile',
                ],

                'female-pregnant' => [
                    'status' => 'applicable',
                    'priority' => 20,
                    'reason' => 'Pregnancy changes coagulation interpretation',
                ],

                'senior' => [
                    'status' => 'applicable',
                    'priority' => 30,
                    'reason' => 'Thrombosis/bleeding risk interpretation changes with age',
                ],

                'cardiovascular-risk' => [
                    'status' => 'applicable',
                    'priority' => 40,
                    'reason' => 'Coagulation markers are relevant to thrombotic cardiovascular risk',
                ],

            ],

            'total-t4' => [
                'general-adult' => [
                    'status' => 'applicable',
                    'primary' => true,
                    'priority' => 10,
                    'reason' => 'Base adult interpretation profile',
                ],

                'female-adult' => [
                    'status' => 'applicable',
                    'priority' => 20,
                    'reason' => 'Thyroid disease prevalence and interpretation are especially relevant in women',
                ],

                'female-pregnant' => [
                    'status' => 'applicable',
                    'priority' => 30,
                    'reason' => 'Pregnancy requires separate thyroid interpretation',
                ],

                'senior' => [
                    'status' => 'applicable',
                    'priority' => 40,
                    'reason' => 'TSH/thyroid hormone interpretation can differ in older adults',
                ],

                'child' => [
                    'status' => 'applicable',
                    'priority' => 50,
                    'reason' => 'Pediatric thyroid interpretation differs',
                ],

                'teen' => [
                    'status' => 'applicable',
                    'priority' => 60,
                    'reason' => 'Teen thyroid interpretation differs',
                ],

                'thyroid-risk' => [
                    'status' => 'applicable',
                    'priority' => 70,
                    'reason' => 'Core thyroid risk profile marker',
                ],

            ],

            'total-t3' => [
                'general-adult' => [
                    'status' => 'applicable',
                    'primary' => true,
                    'priority' => 10,
                    'reason' => 'Base adult interpretation profile',
                ],

                'female-adult' => [
                    'status' => 'applicable',
                    'priority' => 20,
                    'reason' => 'Thyroid disease prevalence and interpretation are especially relevant in women',
                ],

                'female-pregnant' => [
                    'status' => 'applicable',
                    'priority' => 30,
                    'reason' => 'Pregnancy requires separate thyroid interpretation',
                ],

                'senior' => [
                    'status' => 'applicable',
                    'priority' => 40,
                    'reason' => 'TSH/thyroid hormone interpretation can differ in older adults',
                ],

                'child' => [
                    'status' => 'applicable',
                    'priority' => 50,
                    'reason' => 'Pediatric thyroid interpretation differs',
                ],

                'teen' => [
                    'status' => 'applicable',
                    'priority' => 60,
                    'reason' => 'Teen thyroid interpretation differs',
                ],

                'thyroid-risk' => [
                    'status' => 'applicable',
                    'priority' => 70,
                    'reason' => 'Core thyroid risk profile marker',
                ],

            ],

            'anti-thyroglobulin' => [
                'general-adult' => [
                    'status' => 'applicable',
                    'primary' => true,
                    'priority' => 10,
                    'reason' => 'Base adult interpretation profile',
                ],

                'female-adult' => [
                    'status' => 'applicable',
                    'priority' => 20,
                    'reason' => 'Thyroid disease prevalence and interpretation are especially relevant in women',
                ],

                'female-pregnant' => [
                    'status' => 'applicable',
                    'priority' => 30,
                    'reason' => 'Pregnancy requires separate thyroid interpretation',
                ],

                'senior' => [
                    'status' => 'applicable',
                    'priority' => 40,
                    'reason' => 'TSH/thyroid hormone interpretation can differ in older adults',
                ],

                'child' => [
                    'status' => 'applicable',
                    'priority' => 50,
                    'reason' => 'Pediatric thyroid interpretation differs',
                ],

                'teen' => [
                    'status' => 'applicable',
                    'priority' => 60,
                    'reason' => 'Teen thyroid interpretation differs',
                ],

                'thyroid-risk' => [
                    'status' => 'applicable',
                    'priority' => 70,
                    'reason' => 'Core thyroid risk profile marker',
                ],

            ],

            'thyroglobulin' => [
                'general-adult' => [
                    'status' => 'applicable',
                    'primary' => true,
                    'priority' => 10,
                    'reason' => 'Base adult interpretation profile',
                ],

                'female-adult' => [
                    'status' => 'applicable',
                    'priority' => 20,
                    'reason' => 'Thyroid disease prevalence and interpretation are especially relevant in women',
                ],

                'female-pregnant' => [
                    'status' => 'applicable',
                    'priority' => 30,
                    'reason' => 'Pregnancy requires separate thyroid interpretation',
                ],

                'senior' => [
                    'status' => 'applicable',
                    'priority' => 40,
                    'reason' => 'TSH/thyroid hormone interpretation can differ in older adults',
                ],

                'child' => [
                    'status' => 'applicable',
                    'priority' => 50,
                    'reason' => 'Pediatric thyroid interpretation differs',
                ],

                'teen' => [
                    'status' => 'applicable',
                    'priority' => 60,
                    'reason' => 'Teen thyroid interpretation differs',
                ],

                'thyroid-risk' => [
                    'status' => 'applicable',
                    'priority' => 70,
                    'reason' => 'Core thyroid risk profile marker',
                ],

            ],

            'pth' => [
                'general-adult' => [
                    'status' => 'applicable',
                    'primary' => true,
                    'priority' => 10,
                    'reason' => 'Base adult interpretation profile',
                ],

                'female-postmenopause' => [
                    'status' => 'applicable',
                    'priority' => 20,
                    'reason' => 'Postmenopause changes bone/mineral metabolism context',
                ],

                'senior' => [
                    'status' => 'applicable',
                    'priority' => 30,
                    'reason' => 'PTH interpretation changes with age, renal and bone context',
                ],

                'child' => [
                    'status' => 'applicable',
                    'priority' => 40,
                    'reason' => 'Pediatric PTH interpretation differs',
                ],

                'teen' => [
                    'status' => 'applicable',
                    'priority' => 50,
                    'reason' => 'Teen PTH interpretation differs',
                ],

            ],

            'acth' => [
                'general-adult' => [
                    'status' => 'applicable',
                    'primary' => true,
                    'priority' => 10,
                    'reason' => 'Base adult interpretation profile',
                ],

                'senior' => [
                    'status' => 'applicable',
                    'priority' => 20,
                    'reason' => 'Endocrine interpretation can be age/context dependent',
                ],

                'child' => [
                    'status' => 'applicable',
                    'priority' => 30,
                    'reason' => 'Pediatric adrenal axis interpretation differs',
                ],

                'teen' => [
                    'status' => 'applicable',
                    'priority' => 40,
                    'reason' => 'Teen adrenal axis interpretation differs',
                ],

            ],

            'aldosterone' => [
                'general-adult' => [
                    'status' => 'applicable',
                    'primary' => true,
                    'priority' => 10,
                    'reason' => 'Base adult interpretation profile',
                ],

                'senior' => [
                    'status' => 'applicable',
                    'priority' => 20,
                    'reason' => 'Hypertension/renal context changes with age',
                ],

                'cardiovascular-risk' => [
                    'status' => 'applicable',
                    'priority' => 30,
                    'reason' => 'Aldosterone/renin axis is relevant to hypertension and cardiovascular risk',
                ],

            ],

            'renin' => [
                'general-adult' => [
                    'status' => 'applicable',
                    'primary' => true,
                    'priority' => 10,
                    'reason' => 'Base adult interpretation profile',
                ],

                'senior' => [
                    'status' => 'applicable',
                    'priority' => 20,
                    'reason' => 'Hypertension/renal context changes with age',
                ],

                'cardiovascular-risk' => [
                    'status' => 'applicable',
                    'priority' => 30,
                    'reason' => 'Aldosterone/renin axis is relevant to hypertension and cardiovascular risk',
                ],

            ],

            'testosterone-free' => [
                'male-adult' => [
                    'status' => 'applicable',
                    'primary' => true,
                    'priority' => 10,
                    'reason' => 'Primary profile for free testosterone interpretation',
                ],

                'female-adult' => [
                    'status' => 'applicable',
                    'priority' => 20,
                    'reason' => 'Female androgen interpretation differs',
                ],

                'teen' => [
                    'status' => 'applicable',
                    'priority' => 30,
                    'reason' => 'Pubertal context changes interpretation',
                ],

                'senior' => [
                    'status' => 'applicable',
                    'priority' => 40,
                    'reason' => 'Age changes androgen interpretation',
                ],

            ],

            'hcg' => [
                'female-pregnant' => [
                    'status' => 'applicable',
                    'primary' => true,
                    'priority' => 10,
                    'reason' => 'Primary pregnancy-related interpretation profile',
                ],

                'female-adult' => [
                    'status' => 'applicable',
                    'priority' => 20,
                    'reason' => 'Relevant for pregnancy assessment and some tumor contexts',
                ],

                'male-adult' => [
                    'status' => 'applicable',
                    'priority' => 30,
                    'reason' => 'Can be relevant in selected male tumor/endocrine contexts',
                ],

            ],

            'afp-pregnancy' => [
                'female-pregnant' => [
                    'status' => 'applicable',
                    'primary' => true,
                    'priority' => 10,
                    'reason' => 'Primary prenatal screening interpretation profile',
                ],

            ],

            'inhibin-b' => [
                'male-adult' => [
                    'status' => 'applicable',
                    'primary' => true,
                    'priority' => 10,
                    'reason' => 'Male fertility/endocrine interpretation profile',
                ],

                'female-adult' => [
                    'status' => 'applicable',
                    'priority' => 20,
                    'reason' => 'Female ovarian reserve/endocrine interpretation profile',
                ],

                'teen' => [
                    'status' => 'applicable',
                    'priority' => 30,
                    'reason' => 'Pubertal context can affect interpretation',
                ],

            ],

            'urine-color' => [
                'general-adult' => [
                    'status' => 'applicable',
                    'primary' => true,
                    'priority' => 10,
                    'reason' => 'Base adult interpretation profile',
                ],

                'female-pregnant' => [
                    'status' => 'applicable',
                    'priority' => 20,
                    'reason' => 'Pregnancy changes urinary screening relevance',
                ],

                'senior' => [
                    'status' => 'applicable',
                    'priority' => 30,
                    'reason' => 'Urinary findings interpretation changes with age',
                ],

                'child' => [
                    'status' => 'applicable',
                    'priority' => 40,
                    'reason' => 'Pediatric urinalysis interpretation differs',
                ],

                'teen' => [
                    'status' => 'applicable',
                    'priority' => 50,
                    'reason' => 'Teen urinalysis interpretation differs',
                ],

            ],

            'urine-specific-gravity' => [
                'general-adult' => [
                    'status' => 'applicable',
                    'primary' => true,
                    'priority' => 10,
                    'reason' => 'Base adult interpretation profile',
                ],

                'female-pregnant' => [
                    'status' => 'applicable',
                    'priority' => 20,
                    'reason' => 'Pregnancy changes urinary screening relevance',
                ],

                'senior' => [
                    'status' => 'applicable',
                    'priority' => 30,
                    'reason' => 'Urinary findings interpretation changes with age',
                ],

                'child' => [
                    'status' => 'applicable',
                    'priority' => 40,
                    'reason' => 'Pediatric urinalysis interpretation differs',
                ],

                'teen' => [
                    'status' => 'applicable',
                    'priority' => 50,
                    'reason' => 'Teen urinalysis interpretation differs',
                ],

            ],

            'urine-ph' => [
                'general-adult' => [
                    'status' => 'applicable',
                    'primary' => true,
                    'priority' => 10,
                    'reason' => 'Base adult interpretation profile',
                ],

                'female-pregnant' => [
                    'status' => 'applicable',
                    'priority' => 20,
                    'reason' => 'Pregnancy changes urinary screening relevance',
                ],

                'senior' => [
                    'status' => 'applicable',
                    'priority' => 30,
                    'reason' => 'Urinary findings interpretation changes with age',
                ],

                'child' => [
                    'status' => 'applicable',
                    'priority' => 40,
                    'reason' => 'Pediatric urinalysis interpretation differs',
                ],

                'teen' => [
                    'status' => 'applicable',
                    'priority' => 50,
                    'reason' => 'Teen urinalysis interpretation differs',
                ],

            ],

            'urine-protein' => [
                'general-adult' => [
                    'status' => 'applicable',
                    'primary' => true,
                    'priority' => 10,
                    'reason' => 'Base adult interpretation profile',
                ],

                'female-pregnant' => [
                    'status' => 'applicable',
                    'priority' => 20,
                    'reason' => 'Pregnancy changes urinary screening relevance',
                ],

                'senior' => [
                    'status' => 'applicable',
                    'priority' => 30,
                    'reason' => 'Urinary findings interpretation changes with age',
                ],

                'child' => [
                    'status' => 'applicable',
                    'priority' => 40,
                    'reason' => 'Pediatric urinalysis interpretation differs',
                ],

                'teen' => [
                    'status' => 'applicable',
                    'priority' => 50,
                    'reason' => 'Teen urinalysis interpretation differs',
                ],

            ],

            'urine-glucose' => [
                'general-adult' => [
                    'status' => 'applicable',
                    'primary' => true,
                    'priority' => 10,
                    'reason' => 'Base adult interpretation profile',
                ],

                'female-pregnant' => [
                    'status' => 'applicable',
                    'priority' => 20,
                    'reason' => 'Pregnancy changes urinary screening relevance',
                ],

                'senior' => [
                    'status' => 'applicable',
                    'priority' => 30,
                    'reason' => 'Urinary findings interpretation changes with age',
                ],

                'child' => [
                    'status' => 'applicable',
                    'priority' => 40,
                    'reason' => 'Pediatric urinalysis interpretation differs',
                ],

                'teen' => [
                    'status' => 'applicable',
                    'priority' => 50,
                    'reason' => 'Teen urinalysis interpretation differs',
                ],

                'insulin-resistance' => [
                    'status' => 'applicable',
                    'priority' => 60,
                    'reason' => 'Urine glucose is relevant to glucose metabolism decompensation',
                ],

            ],

            'urine-ketones' => [
                'general-adult' => [
                    'status' => 'applicable',
                    'primary' => true,
                    'priority' => 10,
                    'reason' => 'Base adult interpretation profile',
                ],

                'female-pregnant' => [
                    'status' => 'applicable',
                    'priority' => 20,
                    'reason' => 'Pregnancy changes urinary screening relevance',
                ],

                'senior' => [
                    'status' => 'applicable',
                    'priority' => 30,
                    'reason' => 'Urinary findings interpretation changes with age',
                ],

                'child' => [
                    'status' => 'applicable',
                    'priority' => 40,
                    'reason' => 'Pediatric urinalysis interpretation differs',
                ],

                'teen' => [
                    'status' => 'applicable',
                    'priority' => 50,
                    'reason' => 'Teen urinalysis interpretation differs',
                ],

                'insulin-resistance' => [
                    'status' => 'applicable',
                    'priority' => 60,
                    'reason' => 'Urine ketones are relevant to metabolic decompensation context',
                ],

            ],

            'urine-blood' => [
                'general-adult' => [
                    'status' => 'applicable',
                    'primary' => true,
                    'priority' => 10,
                    'reason' => 'Base adult interpretation profile',
                ],

                'female-pregnant' => [
                    'status' => 'applicable',
                    'priority' => 20,
                    'reason' => 'Pregnancy changes urinary screening relevance',
                ],

                'senior' => [
                    'status' => 'applicable',
                    'priority' => 30,
                    'reason' => 'Urinary findings interpretation changes with age',
                ],

                'child' => [
                    'status' => 'applicable',
                    'priority' => 40,
                    'reason' => 'Pediatric urinalysis interpretation differs',
                ],

                'teen' => [
                    'status' => 'applicable',
                    'priority' => 50,
                    'reason' => 'Teen urinalysis interpretation differs',
                ],

            ],

            'urine-rbc' => [
                'general-adult' => [
                    'status' => 'applicable',
                    'primary' => true,
                    'priority' => 10,
                    'reason' => 'Base adult interpretation profile',
                ],

                'female-pregnant' => [
                    'status' => 'applicable',
                    'priority' => 20,
                    'reason' => 'Pregnancy changes urinary screening relevance',
                ],

                'senior' => [
                    'status' => 'applicable',
                    'priority' => 30,
                    'reason' => 'Urinary findings interpretation changes with age',
                ],

                'child' => [
                    'status' => 'applicable',
                    'priority' => 40,
                    'reason' => 'Pediatric urinalysis interpretation differs',
                ],

                'teen' => [
                    'status' => 'applicable',
                    'priority' => 50,
                    'reason' => 'Teen urinalysis interpretation differs',
                ],

            ],

            'urine-wbc' => [
                'general-adult' => [
                    'status' => 'applicable',
                    'primary' => true,
                    'priority' => 10,
                    'reason' => 'Base adult interpretation profile',
                ],

                'female-pregnant' => [
                    'status' => 'applicable',
                    'priority' => 20,
                    'reason' => 'Pregnancy changes urinary screening relevance',
                ],

                'senior' => [
                    'status' => 'applicable',
                    'priority' => 30,
                    'reason' => 'Urinary findings interpretation changes with age',
                ],

                'child' => [
                    'status' => 'applicable',
                    'priority' => 40,
                    'reason' => 'Pediatric urinalysis interpretation differs',
                ],

                'teen' => [
                    'status' => 'applicable',
                    'priority' => 50,
                    'reason' => 'Teen urinalysis interpretation differs',
                ],

            ],

            'urine-nitrite' => [
                'general-adult' => [
                    'status' => 'applicable',
                    'primary' => true,
                    'priority' => 10,
                    'reason' => 'Base adult interpretation profile',
                ],

                'female-pregnant' => [
                    'status' => 'applicable',
                    'priority' => 20,
                    'reason' => 'Pregnancy changes urinary screening relevance',
                ],

                'senior' => [
                    'status' => 'applicable',
                    'priority' => 30,
                    'reason' => 'Urinary findings interpretation changes with age',
                ],

                'child' => [
                    'status' => 'applicable',
                    'priority' => 40,
                    'reason' => 'Pediatric urinalysis interpretation differs',
                ],

                'teen' => [
                    'status' => 'applicable',
                    'priority' => 50,
                    'reason' => 'Teen urinalysis interpretation differs',
                ],

            ],

            'urine-bacteria' => [
                'general-adult' => [
                    'status' => 'applicable',
                    'primary' => true,
                    'priority' => 10,
                    'reason' => 'Base adult interpretation profile',
                ],

                'female-pregnant' => [
                    'status' => 'applicable',
                    'priority' => 20,
                    'reason' => 'Pregnancy changes urinary screening relevance',
                ],

                'senior' => [
                    'status' => 'applicable',
                    'priority' => 30,
                    'reason' => 'Urinary findings interpretation changes with age',
                ],

                'child' => [
                    'status' => 'applicable',
                    'priority' => 40,
                    'reason' => 'Pediatric urinalysis interpretation differs',
                ],

                'teen' => [
                    'status' => 'applicable',
                    'priority' => 50,
                    'reason' => 'Teen urinalysis interpretation differs',
                ],

            ],

            'urine-epithelial-cells' => [
                'general-adult' => [
                    'status' => 'applicable',
                    'primary' => true,
                    'priority' => 10,
                    'reason' => 'Base adult interpretation profile',
                ],

                'female-pregnant' => [
                    'status' => 'applicable',
                    'priority' => 20,
                    'reason' => 'Pregnancy changes urinary screening relevance',
                ],

                'senior' => [
                    'status' => 'applicable',
                    'priority' => 30,
                    'reason' => 'Urinary findings interpretation changes with age',
                ],

                'child' => [
                    'status' => 'applicable',
                    'priority' => 40,
                    'reason' => 'Pediatric urinalysis interpretation differs',
                ],

                'teen' => [
                    'status' => 'applicable',
                    'priority' => 50,
                    'reason' => 'Teen urinalysis interpretation differs',
                ],

            ],

            'urine-casts' => [
                'general-adult' => [
                    'status' => 'applicable',
                    'primary' => true,
                    'priority' => 10,
                    'reason' => 'Base adult interpretation profile',
                ],

                'female-pregnant' => [
                    'status' => 'applicable',
                    'priority' => 20,
                    'reason' => 'Pregnancy changes urinary screening relevance',
                ],

                'senior' => [
                    'status' => 'applicable',
                    'priority' => 30,
                    'reason' => 'Urinary findings interpretation changes with age',
                ],

                'child' => [
                    'status' => 'applicable',
                    'priority' => 40,
                    'reason' => 'Pediatric urinalysis interpretation differs',
                ],

                'teen' => [
                    'status' => 'applicable',
                    'priority' => 50,
                    'reason' => 'Teen urinalysis interpretation differs',
                ],

            ],

            'urine-albumin-creatinine-ratio' => [
                'general-adult' => [
                    'status' => 'applicable',
                    'primary' => true,
                    'priority' => 10,
                    'reason' => 'Base adult interpretation profile',
                ],

                'female-pregnant' => [
                    'status' => 'applicable',
                    'priority' => 20,
                    'reason' => 'Pregnancy screening can involve proteinuria/renal risk',
                ],

                'senior' => [
                    'status' => 'applicable',
                    'priority' => 30,
                    'reason' => 'Albuminuria interpretation changes with renal/cardiovascular age risk',
                ],

                'cardiovascular-risk' => [
                    'status' => 'applicable',
                    'priority' => 40,
                    'reason' => 'Albuminuria is a cardiovascular and renal risk marker',
                ],

                'insulin-resistance' => [
                    'status' => 'applicable',
                    'priority' => 50,
                    'reason' => 'Albuminuria is relevant to diabetes/insulin resistance risk',
                ],

            ],

            'urine-microalbumin' => [
                'general-adult' => [
                    'status' => 'applicable',
                    'primary' => true,
                    'priority' => 10,
                    'reason' => 'Base adult interpretation profile',
                ],

                'female-pregnant' => [
                    'status' => 'applicable',
                    'priority' => 20,
                    'reason' => 'Pregnancy screening can involve proteinuria/renal risk',
                ],

                'senior' => [
                    'status' => 'applicable',
                    'priority' => 30,
                    'reason' => 'Albuminuria interpretation changes with renal/cardiovascular age risk',
                ],

                'cardiovascular-risk' => [
                    'status' => 'applicable',
                    'priority' => 40,
                    'reason' => 'Albuminuria is a cardiovascular and renal risk marker',
                ],

                'insulin-resistance' => [
                    'status' => 'applicable',
                    'priority' => 50,
                    'reason' => 'Albuminuria is relevant to diabetes/insulin resistance risk',
                ],

            ],

            'urine-creatinine' => [
                'general-adult' => [
                    'status' => 'applicable',
                    'primary' => true,
                    'priority' => 10,
                    'reason' => 'Base adult interpretation profile',
                ],

                'female-pregnant' => [
                    'status' => 'applicable',
                    'priority' => 20,
                    'reason' => 'Pregnancy changes urinary screening relevance',
                ],

                'senior' => [
                    'status' => 'applicable',
                    'priority' => 30,
                    'reason' => 'Urinary findings interpretation changes with age',
                ],

                'child' => [
                    'status' => 'applicable',
                    'priority' => 40,
                    'reason' => 'Pediatric urinalysis interpretation differs',
                ],

                'teen' => [
                    'status' => 'applicable',
                    'priority' => 50,
                    'reason' => 'Teen urinalysis interpretation differs',
                ],

            ],

            'urine-calcium' => [
                'general-adult' => [
                    'status' => 'applicable',
                    'primary' => true,
                    'priority' => 10,
                    'reason' => 'Base adult interpretation profile',
                ],

                'senior' => [
                    'status' => 'applicable',
                    'priority' => 20,
                    'reason' => 'Stone/mineral risk changes with age',
                ],

                'child' => [
                    'status' => 'applicable',
                    'priority' => 30,
                    'reason' => 'Pediatric urine stone-risk interpretation differs',
                ],

                'teen' => [
                    'status' => 'applicable',
                    'priority' => 40,
                    'reason' => 'Teen urine stone-risk interpretation differs',
                ],

            ],

            'urine-oxalate' => [
                'general-adult' => [
                    'status' => 'applicable',
                    'primary' => true,
                    'priority' => 10,
                    'reason' => 'Base adult interpretation profile',
                ],

                'senior' => [
                    'status' => 'applicable',
                    'priority' => 20,
                    'reason' => 'Stone/mineral risk changes with age',
                ],

                'child' => [
                    'status' => 'applicable',
                    'priority' => 30,
                    'reason' => 'Pediatric urine stone-risk interpretation differs',
                ],

                'teen' => [
                    'status' => 'applicable',
                    'priority' => 40,
                    'reason' => 'Teen urine stone-risk interpretation differs',
                ],

            ],

            'urine-citrate' => [
                'general-adult' => [
                    'status' => 'applicable',
                    'primary' => true,
                    'priority' => 10,
                    'reason' => 'Base adult interpretation profile',
                ],

                'senior' => [
                    'status' => 'applicable',
                    'priority' => 20,
                    'reason' => 'Stone/mineral risk changes with age',
                ],

                'child' => [
                    'status' => 'applicable',
                    'priority' => 30,
                    'reason' => 'Pediatric urine stone-risk interpretation differs',
                ],

                'teen' => [
                    'status' => 'applicable',
                    'priority' => 40,
                    'reason' => 'Teen urine stone-risk interpretation differs',
                ],

            ],

            'fecal-occult-blood' => [
                'general-adult' => [
                    'status' => 'applicable',
                    'primary' => true,
                    'priority' => 10,
                    'reason' => 'Base adult interpretation profile',
                ],

                'senior' => [
                    'status' => 'applicable',
                    'priority' => 20,
                    'reason' => 'Colorectal bleeding/screening relevance increases with age',
                ],

                'cardiovascular-risk' => [
                    'status' => 'applicable',
                    'priority' => 30,
                    'reason' => 'Bleeding risk may matter in antithrombotic/cardiovascular contexts',
                ],

            ],

            'fecal-elastase' => [
                'general-adult' => [
                    'status' => 'applicable',
                    'primary' => true,
                    'priority' => 10,
                    'reason' => 'Base adult interpretation profile',
                ],

                'senior' => [
                    'status' => 'applicable',
                    'priority' => 20,
                    'reason' => 'GI interpretation and risk context changes with age',
                ],

                'child' => [
                    'status' => 'applicable',
                    'priority' => 30,
                    'reason' => 'Pediatric GI interpretation differs',
                ],

                'teen' => [
                    'status' => 'applicable',
                    'priority' => 40,
                    'reason' => 'Teen GI interpretation differs',
                ],

            ],

            'stool-ph' => [
                'general-adult' => [
                    'status' => 'applicable',
                    'primary' => true,
                    'priority' => 10,
                    'reason' => 'Base adult interpretation profile',
                ],

                'senior' => [
                    'status' => 'applicable',
                    'priority' => 20,
                    'reason' => 'GI interpretation and risk context changes with age',
                ],

                'child' => [
                    'status' => 'applicable',
                    'priority' => 30,
                    'reason' => 'Pediatric GI interpretation differs',
                ],

                'teen' => [
                    'status' => 'applicable',
                    'priority' => 40,
                    'reason' => 'Teen GI interpretation differs',
                ],

            ],

            'stool-fat' => [
                'general-adult' => [
                    'status' => 'applicable',
                    'primary' => true,
                    'priority' => 10,
                    'reason' => 'Base adult interpretation profile',
                ],

                'senior' => [
                    'status' => 'applicable',
                    'priority' => 20,
                    'reason' => 'GI interpretation and risk context changes with age',
                ],

                'child' => [
                    'status' => 'applicable',
                    'priority' => 30,
                    'reason' => 'Pediatric GI interpretation differs',
                ],

                'teen' => [
                    'status' => 'applicable',
                    'priority' => 40,
                    'reason' => 'Teen GI interpretation differs',
                ],

            ],

            'helicobacter-pylori-antigen' => [
                'general-adult' => [
                    'status' => 'applicable',
                    'primary' => true,
                    'priority' => 10,
                    'reason' => 'Base adult interpretation profile',
                ],

                'senior' => [
                    'status' => 'applicable',
                    'priority' => 20,
                    'reason' => 'GI interpretation and risk context changes with age',
                ],

                'child' => [
                    'status' => 'applicable',
                    'priority' => 30,
                    'reason' => 'Pediatric GI interpretation differs',
                ],

                'teen' => [
                    'status' => 'applicable',
                    'priority' => 40,
                    'reason' => 'Teen GI interpretation differs',
                ],

            ],

            'helicobacter-urease-test' => [
                'general-adult' => [
                    'status' => 'applicable',
                    'primary' => true,
                    'priority' => 10,
                    'reason' => 'Base adult interpretation profile',
                ],

                'senior' => [
                    'status' => 'applicable',
                    'priority' => 20,
                    'reason' => 'GI interpretation and risk context changes with age',
                ],

                'child' => [
                    'status' => 'applicable',
                    'priority' => 30,
                    'reason' => 'Pediatric GI interpretation differs',
                ],

                'teen' => [
                    'status' => 'applicable',
                    'priority' => 40,
                    'reason' => 'Teen GI interpretation differs',
                ],

            ],

            'pancreatic-amylase' => [
                'general-adult' => [
                    'status' => 'applicable',
                    'primary' => true,
                    'priority' => 10,
                    'reason' => 'Base adult interpretation profile',
                ],

                'senior' => [
                    'status' => 'applicable',
                    'priority' => 20,
                    'reason' => 'Pancreatic/renal context changes with age',
                ],

                'child' => [
                    'status' => 'applicable',
                    'priority' => 30,
                    'reason' => 'Pediatric enzyme interpretation differs',
                ],

                'teen' => [
                    'status' => 'applicable',
                    'priority' => 40,
                    'reason' => 'Teen enzyme interpretation differs',
                ],

            ],

            'pepsinogen-1' => [
                'general-adult' => [
                    'status' => 'applicable',
                    'primary' => true,
                    'priority' => 10,
                    'reason' => 'Base adult interpretation profile',
                ],

                'senior' => [
                    'status' => 'applicable',
                    'priority' => 20,
                    'reason' => 'GI interpretation and risk context changes with age',
                ],

                'child' => [
                    'status' => 'applicable',
                    'priority' => 30,
                    'reason' => 'Pediatric GI interpretation differs',
                ],

                'teen' => [
                    'status' => 'applicable',
                    'priority' => 40,
                    'reason' => 'Teen GI interpretation differs',
                ],

            ],

            'pepsinogen-2' => [
                'general-adult' => [
                    'status' => 'applicable',
                    'primary' => true,
                    'priority' => 10,
                    'reason' => 'Base adult interpretation profile',
                ],

                'senior' => [
                    'status' => 'applicable',
                    'priority' => 20,
                    'reason' => 'GI interpretation and risk context changes with age',
                ],

                'child' => [
                    'status' => 'applicable',
                    'priority' => 30,
                    'reason' => 'Pediatric GI interpretation differs',
                ],

                'teen' => [
                    'status' => 'applicable',
                    'priority' => 40,
                    'reason' => 'Teen GI interpretation differs',
                ],

            ],

            'gastrin-17' => [
                'general-adult' => [
                    'status' => 'applicable',
                    'primary' => true,
                    'priority' => 10,
                    'reason' => 'Base adult interpretation profile',
                ],

                'senior' => [
                    'status' => 'applicable',
                    'priority' => 20,
                    'reason' => 'GI interpretation and risk context changes with age',
                ],

                'child' => [
                    'status' => 'applicable',
                    'priority' => 30,
                    'reason' => 'Pediatric GI interpretation differs',
                ],

                'teen' => [
                    'status' => 'applicable',
                    'priority' => 40,
                    'reason' => 'Teen GI interpretation differs',
                ],

            ],

            'ck-mb' => [
                'general-adult' => [
                    'status' => 'applicable',
                    'primary' => true,
                    'priority' => 10,
                    'reason' => 'Base adult interpretation profile',
                ],

                'senior' => [
                    'status' => 'applicable',
                    'priority' => 20,
                    'reason' => 'Cardiac marker interpretation changes with age and comorbidity',
                ],

                'cardiovascular-risk' => [
                    'status' => 'applicable',
                    'priority' => 30,
                    'reason' => 'Core cardiovascular risk/acute cardiac context marker',
                ],

            ],

            'myoglobin' => [
                'general-adult' => [
                    'status' => 'applicable',
                    'primary' => true,
                    'priority' => 10,
                    'reason' => 'Base adult interpretation profile',
                ],

                'senior' => [
                    'status' => 'applicable',
                    'priority' => 20,
                    'reason' => 'Cardiac marker interpretation changes with age and comorbidity',
                ],

                'cardiovascular-risk' => [
                    'status' => 'applicable',
                    'priority' => 30,
                    'reason' => 'Core cardiovascular risk/acute cardiac context marker',
                ],

            ],

            'bnp' => [
                'general-adult' => [
                    'status' => 'applicable',
                    'primary' => true,
                    'priority' => 10,
                    'reason' => 'Base adult interpretation profile',
                ],

                'senior' => [
                    'status' => 'applicable',
                    'priority' => 20,
                    'reason' => 'Cardiac marker interpretation changes with age and comorbidity',
                ],

                'cardiovascular-risk' => [
                    'status' => 'applicable',
                    'priority' => 30,
                    'reason' => 'Core cardiovascular risk/acute cardiac context marker',
                ],

            ],

            'lp-pla2' => [
                'general-adult' => [
                    'status' => 'applicable',
                    'primary' => true,
                    'priority' => 10,
                    'reason' => 'Base adult interpretation profile',
                ],

                'senior' => [
                    'status' => 'applicable',
                    'priority' => 20,
                    'reason' => 'Cardiac marker interpretation changes with age and comorbidity',
                ],

                'cardiovascular-risk' => [
                    'status' => 'applicable',
                    'priority' => 30,
                    'reason' => 'Core cardiovascular risk/acute cardiac context marker',
                ],

            ],

            'high-sensitivity-troponin' => [
                'general-adult' => [
                    'status' => 'applicable',
                    'primary' => true,
                    'priority' => 10,
                    'reason' => 'Base adult interpretation profile',
                ],

                'senior' => [
                    'status' => 'applicable',
                    'priority' => 20,
                    'reason' => 'Cardiac marker interpretation changes with age and comorbidity',
                ],

                'cardiovascular-risk' => [
                    'status' => 'applicable',
                    'priority' => 30,
                    'reason' => 'Core cardiovascular risk/acute cardiac context marker',
                ],

            ],

            'ana' => [
                'general-adult' => [
                    'status' => 'applicable',
                    'primary' => true,
                    'priority' => 10,
                    'reason' => 'Base adult interpretation profile',
                ],

                'female-adult' => [
                    'status' => 'applicable',
                    'priority' => 20,
                    'reason' => 'Autoimmune disease prevalence and interpretation are often sex-context dependent',
                ],

                'female-pregnant' => [
                    'status' => 'applicable',
                    'priority' => 30,
                    'reason' => 'Autoimmune markers can be relevant to pregnancy risk context',
                ],

                'senior' => [
                    'status' => 'applicable',
                    'priority' => 40,
                    'reason' => 'Autoimmune marker interpretation changes with age',
                ],

                'child' => [
                    'status' => 'applicable',
                    'priority' => 50,
                    'reason' => 'Pediatric autoimmune interpretation differs',
                ],

                'teen' => [
                    'status' => 'applicable',
                    'priority' => 60,
                    'reason' => 'Teen autoimmune interpretation differs',
                ],

            ],

            'anti-dsdna' => [
                'general-adult' => [
                    'status' => 'applicable',
                    'primary' => true,
                    'priority' => 10,
                    'reason' => 'Base adult interpretation profile',
                ],

                'female-adult' => [
                    'status' => 'applicable',
                    'priority' => 20,
                    'reason' => 'Autoimmune disease prevalence and interpretation are often sex-context dependent',
                ],

                'female-pregnant' => [
                    'status' => 'applicable',
                    'priority' => 30,
                    'reason' => 'Autoimmune markers can be relevant to pregnancy risk context',
                ],

                'senior' => [
                    'status' => 'applicable',
                    'priority' => 40,
                    'reason' => 'Autoimmune marker interpretation changes with age',
                ],

                'child' => [
                    'status' => 'applicable',
                    'priority' => 50,
                    'reason' => 'Pediatric autoimmune interpretation differs',
                ],

                'teen' => [
                    'status' => 'applicable',
                    'priority' => 60,
                    'reason' => 'Teen autoimmune interpretation differs',
                ],

            ],

            'ena-screen' => [
                'general-adult' => [
                    'status' => 'applicable',
                    'primary' => true,
                    'priority' => 10,
                    'reason' => 'Base adult interpretation profile',
                ],

                'female-adult' => [
                    'status' => 'applicable',
                    'priority' => 20,
                    'reason' => 'Autoimmune disease prevalence and interpretation are often sex-context dependent',
                ],

                'female-pregnant' => [
                    'status' => 'applicable',
                    'priority' => 30,
                    'reason' => 'Autoimmune markers can be relevant to pregnancy risk context',
                ],

                'senior' => [
                    'status' => 'applicable',
                    'priority' => 40,
                    'reason' => 'Autoimmune marker interpretation changes with age',
                ],

                'child' => [
                    'status' => 'applicable',
                    'priority' => 50,
                    'reason' => 'Pediatric autoimmune interpretation differs',
                ],

                'teen' => [
                    'status' => 'applicable',
                    'priority' => 60,
                    'reason' => 'Teen autoimmune interpretation differs',
                ],

            ],

            'rheumatoid-factor' => [
                'general-adult' => [
                    'status' => 'applicable',
                    'primary' => true,
                    'priority' => 10,
                    'reason' => 'Base adult interpretation profile',
                ],

                'female-adult' => [
                    'status' => 'applicable',
                    'priority' => 20,
                    'reason' => 'Autoimmune disease prevalence and interpretation are often sex-context dependent',
                ],

                'female-pregnant' => [
                    'status' => 'applicable',
                    'priority' => 30,
                    'reason' => 'Autoimmune markers can be relevant to pregnancy risk context',
                ],

                'senior' => [
                    'status' => 'applicable',
                    'priority' => 40,
                    'reason' => 'Autoimmune marker interpretation changes with age',
                ],

                'child' => [
                    'status' => 'applicable',
                    'priority' => 50,
                    'reason' => 'Pediatric autoimmune interpretation differs',
                ],

                'teen' => [
                    'status' => 'applicable',
                    'priority' => 60,
                    'reason' => 'Teen autoimmune interpretation differs',
                ],

            ],

            'anti-ccp' => [
                'general-adult' => [
                    'status' => 'applicable',
                    'primary' => true,
                    'priority' => 10,
                    'reason' => 'Base adult interpretation profile',
                ],

                'female-adult' => [
                    'status' => 'applicable',
                    'priority' => 20,
                    'reason' => 'Autoimmune disease prevalence and interpretation are often sex-context dependent',
                ],

                'female-pregnant' => [
                    'status' => 'applicable',
                    'priority' => 30,
                    'reason' => 'Autoimmune markers can be relevant to pregnancy risk context',
                ],

                'senior' => [
                    'status' => 'applicable',
                    'priority' => 40,
                    'reason' => 'Autoimmune marker interpretation changes with age',
                ],

                'child' => [
                    'status' => 'applicable',
                    'priority' => 50,
                    'reason' => 'Pediatric autoimmune interpretation differs',
                ],

                'teen' => [
                    'status' => 'applicable',
                    'priority' => 60,
                    'reason' => 'Teen autoimmune interpretation differs',
                ],

            ],

            'c3-complement' => [
                'general-adult' => [
                    'status' => 'applicable',
                    'primary' => true,
                    'priority' => 10,
                    'reason' => 'Base adult interpretation profile',
                ],

                'female-adult' => [
                    'status' => 'applicable',
                    'priority' => 20,
                    'reason' => 'Autoimmune disease prevalence and interpretation are often sex-context dependent',
                ],

                'female-pregnant' => [
                    'status' => 'applicable',
                    'priority' => 30,
                    'reason' => 'Autoimmune markers can be relevant to pregnancy risk context',
                ],

                'senior' => [
                    'status' => 'applicable',
                    'priority' => 40,
                    'reason' => 'Autoimmune marker interpretation changes with age',
                ],

                'child' => [
                    'status' => 'applicable',
                    'priority' => 50,
                    'reason' => 'Pediatric autoimmune interpretation differs',
                ],

                'teen' => [
                    'status' => 'applicable',
                    'priority' => 60,
                    'reason' => 'Teen autoimmune interpretation differs',
                ],

            ],

            'c4-complement' => [
                'general-adult' => [
                    'status' => 'applicable',
                    'primary' => true,
                    'priority' => 10,
                    'reason' => 'Base adult interpretation profile',
                ],

                'female-adult' => [
                    'status' => 'applicable',
                    'priority' => 20,
                    'reason' => 'Autoimmune disease prevalence and interpretation are often sex-context dependent',
                ],

                'female-pregnant' => [
                    'status' => 'applicable',
                    'priority' => 30,
                    'reason' => 'Autoimmune markers can be relevant to pregnancy risk context',
                ],

                'senior' => [
                    'status' => 'applicable',
                    'priority' => 40,
                    'reason' => 'Autoimmune marker interpretation changes with age',
                ],

                'child' => [
                    'status' => 'applicable',
                    'priority' => 50,
                    'reason' => 'Pediatric autoimmune interpretation differs',
                ],

                'teen' => [
                    'status' => 'applicable',
                    'priority' => 60,
                    'reason' => 'Teen autoimmune interpretation differs',
                ],

            ],

            'anca' => [
                'general-adult' => [
                    'status' => 'applicable',
                    'primary' => true,
                    'priority' => 10,
                    'reason' => 'Base adult interpretation profile',
                ],

                'female-adult' => [
                    'status' => 'applicable',
                    'priority' => 20,
                    'reason' => 'Autoimmune disease prevalence and interpretation are often sex-context dependent',
                ],

                'female-pregnant' => [
                    'status' => 'applicable',
                    'priority' => 30,
                    'reason' => 'Autoimmune markers can be relevant to pregnancy risk context',
                ],

                'senior' => [
                    'status' => 'applicable',
                    'priority' => 40,
                    'reason' => 'Autoimmune marker interpretation changes with age',
                ],

                'child' => [
                    'status' => 'applicable',
                    'priority' => 50,
                    'reason' => 'Pediatric autoimmune interpretation differs',
                ],

                'teen' => [
                    'status' => 'applicable',
                    'priority' => 60,
                    'reason' => 'Teen autoimmune interpretation differs',
                ],

            ],

            'anti-mpo' => [
                'general-adult' => [
                    'status' => 'applicable',
                    'primary' => true,
                    'priority' => 10,
                    'reason' => 'Base adult interpretation profile',
                ],

                'female-adult' => [
                    'status' => 'applicable',
                    'priority' => 20,
                    'reason' => 'Autoimmune disease prevalence and interpretation are often sex-context dependent',
                ],

                'female-pregnant' => [
                    'status' => 'applicable',
                    'priority' => 30,
                    'reason' => 'Autoimmune markers can be relevant to pregnancy risk context',
                ],

                'senior' => [
                    'status' => 'applicable',
                    'priority' => 40,
                    'reason' => 'Autoimmune marker interpretation changes with age',
                ],

                'child' => [
                    'status' => 'applicable',
                    'priority' => 50,
                    'reason' => 'Pediatric autoimmune interpretation differs',
                ],

                'teen' => [
                    'status' => 'applicable',
                    'priority' => 60,
                    'reason' => 'Teen autoimmune interpretation differs',
                ],

            ],

            'anti-pr3' => [
                'general-adult' => [
                    'status' => 'applicable',
                    'primary' => true,
                    'priority' => 10,
                    'reason' => 'Base adult interpretation profile',
                ],

                'female-adult' => [
                    'status' => 'applicable',
                    'priority' => 20,
                    'reason' => 'Autoimmune disease prevalence and interpretation are often sex-context dependent',
                ],

                'female-pregnant' => [
                    'status' => 'applicable',
                    'priority' => 30,
                    'reason' => 'Autoimmune markers can be relevant to pregnancy risk context',
                ],

                'senior' => [
                    'status' => 'applicable',
                    'priority' => 40,
                    'reason' => 'Autoimmune marker interpretation changes with age',
                ],

                'child' => [
                    'status' => 'applicable',
                    'priority' => 50,
                    'reason' => 'Pediatric autoimmune interpretation differs',
                ],

                'teen' => [
                    'status' => 'applicable',
                    'priority' => 60,
                    'reason' => 'Teen autoimmune interpretation differs',
                ],

            ],

            'anticardiolipin-igg' => [
                'general-adult' => [
                    'status' => 'applicable',
                    'primary' => true,
                    'priority' => 10,
                    'reason' => 'Base adult interpretation profile',
                ],

                'female-adult' => [
                    'status' => 'applicable',
                    'priority' => 20,
                    'reason' => 'Antiphospholipid testing is often relevant in female reproductive/thrombotic context',
                ],

                'female-pregnant' => [
                    'status' => 'applicable',
                    'priority' => 30,
                    'reason' => 'Antiphospholipid markers can affect pregnancy risk interpretation',
                ],

                'cardiovascular-risk' => [
                    'status' => 'applicable',
                    'priority' => 40,
                    'reason' => 'Antiphospholipid markers are relevant to thrombotic risk',
                ],

            ],

            'anticardiolipin-igm' => [
                'general-adult' => [
                    'status' => 'applicable',
                    'primary' => true,
                    'priority' => 10,
                    'reason' => 'Base adult interpretation profile',
                ],

                'female-adult' => [
                    'status' => 'applicable',
                    'priority' => 20,
                    'reason' => 'Antiphospholipid testing is often relevant in female reproductive/thrombotic context',
                ],

                'female-pregnant' => [
                    'status' => 'applicable',
                    'priority' => 30,
                    'reason' => 'Antiphospholipid markers can affect pregnancy risk interpretation',
                ],

                'cardiovascular-risk' => [
                    'status' => 'applicable',
                    'priority' => 40,
                    'reason' => 'Antiphospholipid markers are relevant to thrombotic risk',
                ],

            ],

            'beta-2-glycoprotein-igg' => [
                'general-adult' => [
                    'status' => 'applicable',
                    'primary' => true,
                    'priority' => 10,
                    'reason' => 'Base adult interpretation profile',
                ],

                'female-adult' => [
                    'status' => 'applicable',
                    'priority' => 20,
                    'reason' => 'Antiphospholipid testing is often relevant in female reproductive/thrombotic context',
                ],

                'female-pregnant' => [
                    'status' => 'applicable',
                    'priority' => 30,
                    'reason' => 'Antiphospholipid markers can affect pregnancy risk interpretation',
                ],

                'cardiovascular-risk' => [
                    'status' => 'applicable',
                    'priority' => 40,
                    'reason' => 'Antiphospholipid markers are relevant to thrombotic risk',
                ],

            ],

            'beta-2-glycoprotein-igm' => [
                'general-adult' => [
                    'status' => 'applicable',
                    'primary' => true,
                    'priority' => 10,
                    'reason' => 'Base adult interpretation profile',
                ],

                'female-adult' => [
                    'status' => 'applicable',
                    'priority' => 20,
                    'reason' => 'Antiphospholipid testing is often relevant in female reproductive/thrombotic context',
                ],

                'female-pregnant' => [
                    'status' => 'applicable',
                    'priority' => 30,
                    'reason' => 'Antiphospholipid markers can affect pregnancy risk interpretation',
                ],

                'cardiovascular-risk' => [
                    'status' => 'applicable',
                    'priority' => 40,
                    'reason' => 'Antiphospholipid markers are relevant to thrombotic risk',
                ],

            ],

            'anti-tissue-transglutaminase-iga' => [
                'general-adult' => [
                    'status' => 'applicable',
                    'primary' => true,
                    'priority' => 10,
                    'reason' => 'Base adult interpretation profile',
                ],

                'child' => [
                    'status' => 'applicable',
                    'priority' => 20,
                    'reason' => 'Celiac screening interpretation is important in children',
                ],

                'teen' => [
                    'status' => 'applicable',
                    'priority' => 30,
                    'reason' => 'Celiac screening interpretation is important in teens',
                ],

                'female-pregnant' => [
                    'status' => 'applicable',
                    'priority' => 40,
                    'reason' => 'Celiac/nutritional status can be relevant in pregnancy',
                ],

            ],

            'anti-deamidated-gliadin-igg' => [
                'general-adult' => [
                    'status' => 'applicable',
                    'primary' => true,
                    'priority' => 10,
                    'reason' => 'Base adult interpretation profile',
                ],

                'child' => [
                    'status' => 'applicable',
                    'priority' => 20,
                    'reason' => 'Celiac screening interpretation is important in children',
                ],

                'teen' => [
                    'status' => 'applicable',
                    'priority' => 30,
                    'reason' => 'Celiac screening interpretation is important in teens',
                ],

                'female-pregnant' => [
                    'status' => 'applicable',
                    'priority' => 40,
                    'reason' => 'Celiac/nutritional status can be relevant in pregnancy',
                ],

            ],

            'total-igg' => [
                'general-adult' => [
                    'status' => 'applicable',
                    'primary' => true,
                    'priority' => 10,
                    'reason' => 'Base adult interpretation profile',
                ],

                'child' => [
                    'status' => 'applicable',
                    'priority' => 20,
                    'reason' => 'Pediatric immune/allergy interpretation differs',
                ],

                'teen' => [
                    'status' => 'applicable',
                    'priority' => 30,
                    'reason' => 'Teen immune/allergy interpretation differs',
                ],

                'senior' => [
                    'status' => 'applicable',
                    'priority' => 40,
                    'reason' => 'Immune marker interpretation changes with age',
                ],

            ],

            'total-igm' => [
                'general-adult' => [
                    'status' => 'applicable',
                    'primary' => true,
                    'priority' => 10,
                    'reason' => 'Base adult interpretation profile',
                ],

                'child' => [
                    'status' => 'applicable',
                    'priority' => 20,
                    'reason' => 'Pediatric immune/allergy interpretation differs',
                ],

                'teen' => [
                    'status' => 'applicable',
                    'priority' => 30,
                    'reason' => 'Teen immune/allergy interpretation differs',
                ],

                'senior' => [
                    'status' => 'applicable',
                    'priority' => 40,
                    'reason' => 'Immune marker interpretation changes with age',
                ],

            ],

            'ige-total' => [
                'general-adult' => [
                    'status' => 'applicable',
                    'primary' => true,
                    'priority' => 10,
                    'reason' => 'Base adult interpretation profile',
                ],

                'child' => [
                    'status' => 'applicable',
                    'priority' => 20,
                    'reason' => 'Pediatric immune/allergy interpretation differs',
                ],

                'teen' => [
                    'status' => 'applicable',
                    'priority' => 30,
                    'reason' => 'Teen immune/allergy interpretation differs',
                ],

                'senior' => [
                    'status' => 'applicable',
                    'priority' => 40,
                    'reason' => 'Immune marker interpretation changes with age',
                ],

            ],

            'tryptase' => [
                'general-adult' => [
                    'status' => 'applicable',
                    'primary' => true,
                    'priority' => 10,
                    'reason' => 'Base adult interpretation profile',
                ],

                'child' => [
                    'status' => 'applicable',
                    'priority' => 20,
                    'reason' => 'Pediatric immune/allergy interpretation differs',
                ],

                'teen' => [
                    'status' => 'applicable',
                    'priority' => 30,
                    'reason' => 'Teen immune/allergy interpretation differs',
                ],

                'senior' => [
                    'status' => 'applicable',
                    'priority' => 40,
                    'reason' => 'Immune marker interpretation changes with age',
                ],

            ],

            'ebv-vca-igm' => [
                'general-adult' => [
                    'status' => 'applicable',
                    'primary' => true,
                    'priority' => 10,
                    'reason' => 'Base adult interpretation profile',
                ],

                'child' => [
                    'status' => 'applicable',
                    'priority' => 20,
                    'reason' => 'Pediatric infection interpretation differs',
                ],

                'teen' => [
                    'status' => 'applicable',
                    'priority' => 30,
                    'reason' => 'Teen infection interpretation differs',
                ],

            ],

            'ebv-vca-igg' => [
                'general-adult' => [
                    'status' => 'applicable',
                    'primary' => true,
                    'priority' => 10,
                    'reason' => 'Base adult interpretation profile',
                ],

                'child' => [
                    'status' => 'applicable',
                    'priority' => 20,
                    'reason' => 'Pediatric infection interpretation differs',
                ],

                'teen' => [
                    'status' => 'applicable',
                    'priority' => 30,
                    'reason' => 'Teen infection interpretation differs',
                ],

            ],

            'cmv-igm' => [
                'general-adult' => [
                    'status' => 'applicable',
                    'primary' => true,
                    'priority' => 10,
                    'reason' => 'Base adult interpretation profile',
                ],

                'female-pregnant' => [
                    'status' => 'applicable',
                    'priority' => 20,
                    'reason' => 'Pregnancy screening / fetal risk context can change interpretation',
                ],

                'child' => [
                    'status' => 'applicable',
                    'priority' => 30,
                    'reason' => 'Pediatric infectious disease interpretation differs',
                ],

                'teen' => [
                    'status' => 'applicable',
                    'priority' => 40,
                    'reason' => 'Teen infectious disease interpretation differs',
                ],

            ],

            'cmv-igg' => [
                'general-adult' => [
                    'status' => 'applicable',
                    'primary' => true,
                    'priority' => 10,
                    'reason' => 'Base adult interpretation profile',
                ],

                'female-pregnant' => [
                    'status' => 'applicable',
                    'priority' => 20,
                    'reason' => 'Pregnancy screening / fetal risk context can change interpretation',
                ],

                'child' => [
                    'status' => 'applicable',
                    'priority' => 30,
                    'reason' => 'Pediatric infectious disease interpretation differs',
                ],

                'teen' => [
                    'status' => 'applicable',
                    'priority' => 40,
                    'reason' => 'Teen infectious disease interpretation differs',
                ],

            ],

            'toxoplasma-igm' => [
                'general-adult' => [
                    'status' => 'applicable',
                    'primary' => true,
                    'priority' => 10,
                    'reason' => 'Base adult interpretation profile',
                ],

                'female-pregnant' => [
                    'status' => 'applicable',
                    'priority' => 20,
                    'reason' => 'Pregnancy screening / fetal risk context can change interpretation',
                ],

                'child' => [
                    'status' => 'applicable',
                    'priority' => 30,
                    'reason' => 'Pediatric infectious disease interpretation differs',
                ],

                'teen' => [
                    'status' => 'applicable',
                    'priority' => 40,
                    'reason' => 'Teen infectious disease interpretation differs',
                ],

            ],

            'toxoplasma-igg' => [
                'general-adult' => [
                    'status' => 'applicable',
                    'primary' => true,
                    'priority' => 10,
                    'reason' => 'Base adult interpretation profile',
                ],

                'female-pregnant' => [
                    'status' => 'applicable',
                    'priority' => 20,
                    'reason' => 'Pregnancy screening / fetal risk context can change interpretation',
                ],

                'child' => [
                    'status' => 'applicable',
                    'priority' => 30,
                    'reason' => 'Pediatric infectious disease interpretation differs',
                ],

                'teen' => [
                    'status' => 'applicable',
                    'priority' => 40,
                    'reason' => 'Teen infectious disease interpretation differs',
                ],

            ],

            'hbsag' => [
                'general-adult' => [
                    'status' => 'applicable',
                    'primary' => true,
                    'priority' => 10,
                    'reason' => 'Base adult interpretation profile',
                ],

                'female-pregnant' => [
                    'status' => 'applicable',
                    'priority' => 20,
                    'reason' => 'Pregnancy screening / fetal risk context can change interpretation',
                ],

                'child' => [
                    'status' => 'applicable',
                    'priority' => 30,
                    'reason' => 'Pediatric infectious disease interpretation differs',
                ],

                'teen' => [
                    'status' => 'applicable',
                    'priority' => 40,
                    'reason' => 'Teen infectious disease interpretation differs',
                ],

            ],

            'anti-hbs' => [
                'general-adult' => [
                    'status' => 'applicable',
                    'primary' => true,
                    'priority' => 10,
                    'reason' => 'Base adult interpretation profile',
                ],

                'female-pregnant' => [
                    'status' => 'applicable',
                    'priority' => 20,
                    'reason' => 'Pregnancy screening / fetal risk context can change interpretation',
                ],

                'child' => [
                    'status' => 'applicable',
                    'priority' => 30,
                    'reason' => 'Pediatric infectious disease interpretation differs',
                ],

                'teen' => [
                    'status' => 'applicable',
                    'priority' => 40,
                    'reason' => 'Teen infectious disease interpretation differs',
                ],

            ],

            'anti-hbc-total' => [
                'general-adult' => [
                    'status' => 'applicable',
                    'primary' => true,
                    'priority' => 10,
                    'reason' => 'Base adult interpretation profile',
                ],

                'female-pregnant' => [
                    'status' => 'applicable',
                    'priority' => 20,
                    'reason' => 'Pregnancy screening / fetal risk context can change interpretation',
                ],

                'child' => [
                    'status' => 'applicable',
                    'priority' => 30,
                    'reason' => 'Pediatric infectious disease interpretation differs',
                ],

                'teen' => [
                    'status' => 'applicable',
                    'priority' => 40,
                    'reason' => 'Teen infectious disease interpretation differs',
                ],

            ],

            'anti-hcv' => [
                'general-adult' => [
                    'status' => 'applicable',
                    'primary' => true,
                    'priority' => 10,
                    'reason' => 'Base adult interpretation profile',
                ],

                'female-pregnant' => [
                    'status' => 'applicable',
                    'priority' => 20,
                    'reason' => 'Pregnancy screening / fetal risk context can change interpretation',
                ],

                'child' => [
                    'status' => 'applicable',
                    'priority' => 30,
                    'reason' => 'Pediatric infectious disease interpretation differs',
                ],

                'teen' => [
                    'status' => 'applicable',
                    'priority' => 40,
                    'reason' => 'Teen infectious disease interpretation differs',
                ],

            ],

            'hcv-rna' => [
                'general-adult' => [
                    'status' => 'applicable',
                    'primary' => true,
                    'priority' => 10,
                    'reason' => 'Base adult interpretation profile',
                ],

                'female-pregnant' => [
                    'status' => 'applicable',
                    'priority' => 20,
                    'reason' => 'Pregnancy screening / fetal risk context can change interpretation',
                ],

                'child' => [
                    'status' => 'applicable',
                    'priority' => 30,
                    'reason' => 'Pediatric infectious disease interpretation differs',
                ],

                'teen' => [
                    'status' => 'applicable',
                    'priority' => 40,
                    'reason' => 'Teen infectious disease interpretation differs',
                ],

            ],

            'hiv-ag-ab' => [
                'general-adult' => [
                    'status' => 'applicable',
                    'primary' => true,
                    'priority' => 10,
                    'reason' => 'Base adult interpretation profile',
                ],

                'female-pregnant' => [
                    'status' => 'applicable',
                    'priority' => 20,
                    'reason' => 'Pregnancy screening / fetal risk context can change interpretation',
                ],

                'child' => [
                    'status' => 'applicable',
                    'priority' => 30,
                    'reason' => 'Pediatric infectious disease interpretation differs',
                ],

                'teen' => [
                    'status' => 'applicable',
                    'priority' => 40,
                    'reason' => 'Teen infectious disease interpretation differs',
                ],

            ],

            'rpr' => [
                'general-adult' => [
                    'status' => 'applicable',
                    'primary' => true,
                    'priority' => 10,
                    'reason' => 'Base adult interpretation profile',
                ],

                'female-pregnant' => [
                    'status' => 'applicable',
                    'priority' => 20,
                    'reason' => 'Pregnancy screening / fetal risk context can change interpretation',
                ],

                'child' => [
                    'status' => 'applicable',
                    'priority' => 30,
                    'reason' => 'Pediatric infectious disease interpretation differs',
                ],

                'teen' => [
                    'status' => 'applicable',
                    'priority' => 40,
                    'reason' => 'Teen infectious disease interpretation differs',
                ],

            ],

            'treponema-pallidum-antibodies' => [
                'general-adult' => [
                    'status' => 'applicable',
                    'primary' => true,
                    'priority' => 10,
                    'reason' => 'Base adult interpretation profile',
                ],

                'female-pregnant' => [
                    'status' => 'applicable',
                    'priority' => 20,
                    'reason' => 'Pregnancy screening / fetal risk context can change interpretation',
                ],

                'child' => [
                    'status' => 'applicable',
                    'priority' => 30,
                    'reason' => 'Pediatric infectious disease interpretation differs',
                ],

                'teen' => [
                    'status' => 'applicable',
                    'priority' => 40,
                    'reason' => 'Teen infectious disease interpretation differs',
                ],

            ],

            'psa-total' => [
                'male-adult' => [
                    'status' => 'applicable',
                    'primary' => true,
                    'priority' => 10,
                    'reason' => 'Male-specific prostate marker',
                ],

                'senior' => [
                    'status' => 'applicable',
                    'priority' => 20,
                    'reason' => 'PSA interpretation is strongly age-context dependent',
                ],

            ],

            'psa-free' => [
                'male-adult' => [
                    'status' => 'applicable',
                    'primary' => true,
                    'priority' => 10,
                    'reason' => 'Male-specific prostate marker',
                ],

                'senior' => [
                    'status' => 'applicable',
                    'priority' => 20,
                    'reason' => 'PSA interpretation is strongly age-context dependent',
                ],

            ],

            'cea' => [
                'general-adult' => [
                    'status' => 'applicable',
                    'primary' => true,
                    'priority' => 10,
                    'reason' => 'Base adult interpretation profile',
                ],

                'senior' => [
                    'status' => 'applicable',
                    'priority' => 20,
                    'reason' => 'Tumor marker interpretation and risk context increase with age',
                ],

            ],

            'ca-125' => [
                'female-adult' => [
                    'status' => 'applicable',
                    'primary' => true,
                    'priority' => 10,
                    'reason' => 'Female gynecologic marker interpretation profile',
                ],

                'female-postmenopause' => [
                    'status' => 'applicable',
                    'priority' => 20,
                    'reason' => 'Postmenopause changes CA-125 interpretation context',
                ],

                'senior' => [
                    'status' => 'applicable',
                    'priority' => 30,
                    'reason' => 'Tumor marker interpretation changes with age',
                ],

            ],

            'he4' => [
                'female-adult' => [
                    'status' => 'applicable',
                    'primary' => true,
                    'priority' => 10,
                    'reason' => 'Female gynecologic marker interpretation profile',
                ],

                'female-postmenopause' => [
                    'status' => 'applicable',
                    'priority' => 20,
                    'reason' => 'Postmenopause changes CA-125 interpretation context',
                ],

                'senior' => [
                    'status' => 'applicable',
                    'priority' => 30,
                    'reason' => 'Tumor marker interpretation changes with age',
                ],

            ],

            'ca-15-3' => [
                'female-adult' => [
                    'status' => 'applicable',
                    'primary' => true,
                    'priority' => 10,
                    'reason' => 'Breast marker interpretation is primarily female-context',
                ],

                'female-postmenopause' => [
                    'status' => 'applicable',
                    'priority' => 20,
                    'reason' => 'Postmenopause changes breast cancer risk context',
                ],

                'senior' => [
                    'status' => 'applicable',
                    'priority' => 30,
                    'reason' => 'Tumor marker interpretation changes with age',
                ],

            ],

            'ca-19-9' => [
                'general-adult' => [
                    'status' => 'applicable',
                    'primary' => true,
                    'priority' => 10,
                    'reason' => 'Base adult interpretation profile',
                ],

                'senior' => [
                    'status' => 'applicable',
                    'priority' => 20,
                    'reason' => 'Tumor marker interpretation and risk context increase with age',
                ],

            ],

            'afp' => [
                'general-adult' => [
                    'status' => 'applicable',
                    'primary' => true,
                    'priority' => 10,
                    'reason' => 'Base adult interpretation profile',
                ],

                'senior' => [
                    'status' => 'applicable',
                    'priority' => 20,
                    'reason' => 'Tumor marker interpretation and risk context increase with age',
                ],

            ],

            'beta-hcg' => [
                'female-pregnant' => [
                    'status' => 'applicable',
                    'primary' => true,
                    'priority' => 10,
                    'reason' => 'Pregnancy-related beta-hCG interpretation',
                ],

                'female-adult' => [
                    'status' => 'applicable',
                    'priority' => 20,
                    'reason' => 'Relevant to pregnancy and selected tumor contexts',
                ],

                'male-adult' => [
                    'status' => 'applicable',
                    'priority' => 30,
                    'reason' => 'Can be relevant in selected male tumor contexts',
                ],

            ],

            'calcitonin' => [
                'general-adult' => [
                    'status' => 'applicable',
                    'primary' => true,
                    'priority' => 10,
                    'reason' => 'Base adult interpretation profile',
                ],

                'senior' => [
                    'status' => 'applicable',
                    'priority' => 20,
                    'reason' => 'Tumor marker interpretation and risk context increase with age',
                ],

            ],

            'chromogranin-a' => [
                'general-adult' => [
                    'status' => 'applicable',
                    'primary' => true,
                    'priority' => 10,
                    'reason' => 'Base adult interpretation profile',
                ],

                'senior' => [
                    'status' => 'applicable',
                    'priority' => 20,
                    'reason' => 'Tumor marker interpretation and risk context increase with age',
                ],

            ],

            'nse' => [
                'general-adult' => [
                    'status' => 'applicable',
                    'primary' => true,
                    'priority' => 10,
                    'reason' => 'Base adult interpretation profile',
                ],

                'senior' => [
                    'status' => 'applicable',
                    'priority' => 20,
                    'reason' => 'Tumor marker interpretation and risk context increase with age',
                ],

            ],

            'cyfra-21-1' => [
                'general-adult' => [
                    'status' => 'applicable',
                    'primary' => true,
                    'priority' => 10,
                    'reason' => 'Base adult interpretation profile',
                ],

                'senior' => [
                    'status' => 'applicable',
                    'priority' => 20,
                    'reason' => 'Tumor marker interpretation and risk context increase with age',
                ],

            ],

            'scc-antigen' => [
                'general-adult' => [
                    'status' => 'applicable',
                    'primary' => true,
                    'priority' => 10,
                    'reason' => 'Base adult interpretation profile',
                ],

                'senior' => [
                    'status' => 'applicable',
                    'priority' => 20,
                    'reason' => 'Tumor marker interpretation and risk context increase with age',
                ],

            ],


            'alt' => [
                'general-adult' => ['status' => 'applicable', 'primary' => true, 'priority' => 10, 'reason' => 'Базовый профиль для интерпретации ALT как печёночного фермента.'],
                'insulin-resistance' => ['status' => 'applicable', 'primary' => false, 'priority' => 30, 'reason' => 'ALT часто важен в контексте метаболического риска и жировой болезни печени.'],
                'senior' => ['status' => 'applicable', 'primary' => false, 'priority' => 60, 'reason' => 'У пожилых пользователей важнее учитывать лекарственную нагрузку, печёночный и общий соматический контекст.'],
                'female-pregnant' => ['status' => 'needs_review', 'primary' => false, 'priority' => 90, 'reason' => 'ALT при беременности важен клинически, но требует отдельной медицинской валидации scoring rules.'],
            ],

            'ast' => [
                'general-adult' => ['status' => 'applicable', 'primary' => true, 'priority' => 10, 'reason' => 'Базовый профиль для AST как фермента печени, мышц и других тканей.'],
                'senior' => ['status' => 'applicable', 'primary' => false, 'priority' => 60, 'reason' => 'У пожилых пользователей AST чаще требует учёта лекарств, мышечной массы и сопутствующих состояний.'],
                'insulin-resistance' => ['status' => 'applicable', 'primary' => false, 'priority' => 40, 'reason' => 'AST может быть полезен вместе с ALT/GGT при метаболическом и печёночном контексте.'],
            ],

            'ggt' => [
                'general-adult' => ['status' => 'applicable', 'primary' => true, 'priority' => 10, 'reason' => 'Базовый профиль для GGT как маркера печени и желчевыводящих путей.'],
                'male-adult' => ['status' => 'applicable', 'primary' => false, 'priority' => 20, 'reason' => 'Для GGT часто используются sex-specific reference ranges.'],
                'female-adult' => ['status' => 'applicable', 'primary' => false, 'priority' => 30, 'reason' => 'Для GGT часто используются sex-specific reference ranges.'],
                'cardiovascular-risk' => ['status' => 'applicable', 'primary' => false, 'priority' => 45, 'reason' => 'GGT может быть значим в кардиометаболическом risk context.'],
                'insulin-resistance' => ['status' => 'applicable', 'primary' => false, 'priority' => 40, 'reason' => 'GGT часто связан с метаболическим и жировым печёночным контекстом.'],
            ],

            'creatinine' => [
                'general-adult' => ['status' => 'applicable', 'primary' => true, 'priority' => 10, 'reason' => 'Базовый профиль для оценки функции почек.'],
                'male-adult' => ['status' => 'applicable', 'primary' => false, 'priority' => 20, 'reason' => 'Креатинин зависит от пола и мышечной массы.'],
                'female-adult' => ['status' => 'applicable', 'primary' => false, 'priority' => 30, 'reason' => 'Креатинин зависит от пола и мышечной массы.'],
                'female-pregnant' => ['status' => 'applicable', 'primary' => false, 'priority' => 40, 'reason' => 'При беременности креатинин требует отдельной интерпретации.'],
                'senior' => ['status' => 'applicable', 'primary' => false, 'priority' => 50, 'reason' => 'У пожилых креатинин может недооценивать снижение функции почек из-за меньшей мышечной массы.'],
                'cardiovascular-risk' => ['status' => 'applicable', 'primary' => false, 'priority' => 60, 'reason' => 'Функция почек важна в cardiovascular risk context.'],
            ],

            'egfr' => [
                'general-adult' => ['status' => 'applicable', 'primary' => true, 'priority' => 10, 'reason' => 'Базовый профиль для оценки расчётной скорости клубочковой фильтрации.'],
                'male-adult' => ['status' => 'applicable', 'primary' => false, 'priority' => 20, 'reason' => 'Расчёт eGFR учитывает пол в используемых формулах.'],
                'female-adult' => ['status' => 'applicable', 'primary' => false, 'priority' => 30, 'reason' => 'Расчёт eGFR учитывает пол в используемых формулах.'],
                'senior' => ['status' => 'applicable', 'primary' => false, 'priority' => 40, 'reason' => 'Возраст существенно влияет на интерпретацию eGFR.'],
                'cardiovascular-risk' => ['status' => 'applicable', 'primary' => false, 'priority' => 50, 'reason' => 'Снижение eGFR важно для кардиометаболического риска.'],
                'female-pregnant' => ['status' => 'needs_review', 'primary' => false, 'priority' => 90, 'reason' => 'eGFR при беременности требует отдельной проверки, стандартные формулы могут быть менее надёжны.'],
            ],

            'ldl' => [
                'general-adult' => ['status' => 'applicable', 'primary' => true, 'priority' => 10, 'reason' => 'Базовый профиль для LDL как ключевого липидного маркера.'],
                'cardiovascular-risk' => ['status' => 'applicable', 'primary' => false, 'priority' => 20, 'reason' => 'LDL является ключевым marker для cardiovascular risk scoring.'],
                'insulin-resistance' => ['status' => 'applicable', 'primary' => false, 'priority' => 40, 'reason' => 'LDL важен в метаболическом контексте вместе с TG/HDL.'],
                'female-postmenopause' => ['status' => 'applicable', 'primary' => false, 'priority' => 50, 'reason' => 'После менопаузы липидный и cardiovascular risk profile меняется.'],
                'senior' => ['status' => 'applicable', 'primary' => false, 'priority' => 60, 'reason' => 'У пожилых LDL интерпретируется в контексте общего cardiovascular risk.'],
            ],

            'triglycerides' => [
                'general-adult' => ['status' => 'applicable', 'primary' => true, 'priority' => 10, 'reason' => 'Базовый профиль для триглицеридов.'],
                'cardiovascular-risk' => ['status' => 'applicable', 'primary' => false, 'priority' => 20, 'reason' => 'Триглицериды важны в cardiovascular risk context.'],
                'insulin-resistance' => ['status' => 'applicable', 'primary' => false, 'priority' => 30, 'reason' => 'Триглицериды особенно важны при insulin resistance и метаболическом риске.'],
                'female-postmenopause' => ['status' => 'applicable', 'primary' => false, 'priority' => 50, 'reason' => 'После менопаузы липидный профиль и риск могут меняться.'],
            ],

            'total-cholesterol' => [
                'general-adult' => ['status' => 'applicable', 'primary' => true, 'priority' => 10, 'reason' => 'Базовый профиль для общего холестерина.'],
                'cardiovascular-risk' => ['status' => 'applicable', 'primary' => false, 'priority' => 20, 'reason' => 'Общий холестерин используется в cardiovascular risk context, но должен оцениваться вместе с LDL/HDL/TG.'],
                'female-postmenopause' => ['status' => 'applicable', 'primary' => false, 'priority' => 50, 'reason' => 'После менопаузы липидный профиль часто меняется.'],
                'senior' => ['status' => 'applicable', 'primary' => false, 'priority' => 60, 'reason' => 'У пожилых общий холестерин оценивается в контексте общего риска и сопутствующих факторов.'],
            ],

            'vitamin-b12' => [
                'general-adult' => ['status' => 'applicable', 'primary' => true, 'priority' => 10, 'reason' => 'Базовый профиль для оценки B12.'],
                'senior' => ['status' => 'applicable', 'primary' => false, 'priority' => 30, 'reason' => 'У пожилых выше риск дефицита B12 и последствий для крови/нервной системы.'],
                'female-pregnant' => ['status' => 'applicable', 'primary' => false, 'priority' => 40, 'reason' => 'B12 важен при беременности и планировании беременности.'],
                'iron-deficiency-risk' => ['status' => 'applicable', 'primary' => false, 'priority' => 50, 'reason' => 'B12 нужен в differential context анемии и дефицитных состояний.'],
            ],

            'folate' => [
                'general-adult' => ['status' => 'applicable', 'primary' => true, 'priority' => 10, 'reason' => 'Базовый профиль для оценки фолата.'],
                'female-pregnant' => ['status' => 'applicable', 'primary' => false, 'priority' => 20, 'reason' => 'Фолат особенно важен при беременности и планировании беременности.'],
                'senior' => ['status' => 'applicable', 'primary' => false, 'priority' => 40, 'reason' => 'У пожилых фолат важен в контексте анемии, питания и дефицитов.'],
                'iron-deficiency-risk' => ['status' => 'applicable', 'primary' => false, 'priority' => 50, 'reason' => 'Фолат нужен в differential context анемии и дефицитных состояний.'],
            ],

            'rbc' => [
                'general-adult' => ['status' => 'applicable', 'primary' => true, 'priority' => 10, 'reason' => 'Базовый профиль для оценки эритроцитов.'],
                'male-adult' => ['status' => 'applicable', 'primary' => false, 'priority' => 20, 'reason' => 'RBC зависит от пола и обычно имеет sex-specific ranges.'],
                'female-adult' => ['status' => 'applicable', 'primary' => false, 'priority' => 30, 'reason' => 'RBC зависит от пола и обычно имеет sex-specific ranges.'],
                'female-pregnant' => ['status' => 'applicable', 'primary' => false, 'priority' => 40, 'reason' => 'Беременность меняет интерпретацию показателей красной крови.'],
                'iron-deficiency-risk' => ['status' => 'applicable', 'primary' => false, 'priority' => 50, 'reason' => 'RBC важен в контексте анемии и дефицита железа.'],
            ],

            'hematocrit' => [
                'general-adult' => ['status' => 'applicable', 'primary' => true, 'priority' => 10, 'reason' => 'Базовый профиль для оценки доли клеток крови.'],
                'male-adult' => ['status' => 'applicable', 'primary' => false, 'priority' => 20, 'reason' => 'Гематокрит имеет выраженные sex-specific ranges.'],
                'female-adult' => ['status' => 'applicable', 'primary' => false, 'priority' => 30, 'reason' => 'Гематокрит имеет выраженные sex-specific ranges.'],
                'female-pregnant' => ['status' => 'applicable', 'primary' => false, 'priority' => 40, 'reason' => 'При беременности гематокрит требует отдельной интерпретации.'],
                'iron-deficiency-risk' => ['status' => 'applicable', 'primary' => false, 'priority' => 50, 'reason' => 'Гематокрит важен в оценке анемии и дефицитных состояний.'],
            ],

            'wbc' => [
                'general-adult' => ['status' => 'applicable', 'primary' => true, 'priority' => 10, 'reason' => 'Базовый профиль для оценки лейкоцитов.'],
                'female-pregnant' => ['status' => 'applicable', 'primary' => false, 'priority' => 30, 'reason' => 'При беременности лейкоциты могут интерпретироваться иначе.'],
                'senior' => ['status' => 'applicable', 'primary' => false, 'priority' => 50, 'reason' => 'У пожилых изменения WBC важны в контексте воспаления, инфекции и общего риска.'],
            ],

            'platelets' => [
                'general-adult' => ['status' => 'applicable', 'primary' => true, 'priority' => 10, 'reason' => 'Базовый профиль для оценки тромбоцитов.'],
                'female-pregnant' => ['status' => 'applicable', 'primary' => false, 'priority' => 30, 'reason' => 'При беременности тромбоциты требуют отдельного внимания.'],
                'senior' => ['status' => 'applicable', 'primary' => false, 'priority' => 50, 'reason' => 'У пожилых тромбоциты важны в контексте воспаления, кровотечений, тромбозов и лекарств.'],
            ],

            'serum-iron' => [
                'general-adult' => ['status' => 'applicable', 'primary' => true, 'priority' => 10, 'reason' => 'Базовый профиль для сывороточного железа.'],
                'female-adult' => ['status' => 'applicable', 'primary' => false, 'priority' => 30, 'reason' => 'У женщин чаще встречается дефицит железа из-за менструальных потерь.'],
                'female-pregnant' => ['status' => 'applicable', 'primary' => false, 'priority' => 40, 'reason' => 'При беременности потребность в железе меняется.'],
                'iron-deficiency-risk' => ['status' => 'applicable', 'primary' => false, 'priority' => 20, 'reason' => 'Сывороточное железо важно в iron deficiency context, но должно оцениваться вместе с ферритином и трансферрином.'],
            ],

            'free-t4' => [
                'general-adult' => ['status' => 'applicable', 'primary' => true, 'priority' => 10, 'reason' => 'Базовый профиль для свободного T4.'],
                'female-pregnant' => ['status' => 'applicable', 'primary' => false, 'priority' => 20, 'reason' => 'Беременность существенно меняет thyroid interpretation.'],
                'thyroid-risk' => ['status' => 'applicable', 'primary' => false, 'priority' => 15, 'reason' => 'Free T4 — ключевой marker при thyroid risk и отклонениях TSH.'],
                'senior' => ['status' => 'applicable', 'primary' => false, 'priority' => 40, 'reason' => 'У пожилых thyroid markers требуют более осторожной интерпретации.'],
            ],

            'free-t3' => [
                'general-adult' => ['status' => 'applicable', 'primary' => true, 'priority' => 10, 'reason' => 'Базовый профиль для свободного T3.'],
                'thyroid-risk' => ['status' => 'applicable', 'primary' => false, 'priority' => 15, 'reason' => 'Free T3 полезен в расширенной thyroid interpretation.'],
                'senior' => ['status' => 'applicable', 'primary' => false, 'priority' => 40, 'reason' => 'У пожилых thyroid markers требуют осторожной интерпретации.'],
            ],

            'bilirubin-total' => [
                'general-adult' => ['status' => 'applicable', 'primary' => true, 'priority' => 10, 'reason' => 'Базовый профиль для общего билирубина.'],
                'senior' => ['status' => 'applicable', 'primary' => false, 'priority' => 50, 'reason' => 'У пожилых билирубин важен в контексте печени, желчных путей, лекарств и сопутствующих состояний.'],
            ],

            'sodium' => [
                'general-adult' => ['status' => 'applicable', 'primary' => true, 'priority' => 10, 'reason' => 'Базовый профиль для оценки натрия и водно-солевого баланса.'],
                'senior' => ['status' => 'applicable', 'primary' => false, 'priority' => 30, 'reason' => 'У пожилых нарушения натрия встречаются чаще и клинически значимее.'],
                'cardiovascular-risk' => ['status' => 'applicable', 'primary' => false, 'priority' => 50, 'reason' => 'Натрий важен при оценке давления, сердечно-сосудистого риска и терапии диуретиками.'],
            ],

            'potassium' => [
                'general-adult' => ['status' => 'applicable', 'primary' => true, 'priority' => 10, 'reason' => 'Базовый профиль для оценки калия.'],
                'senior' => ['status' => 'applicable', 'primary' => false, 'priority' => 30, 'reason' => 'У пожилых калий особенно важен из-за лекарств, почек и сердечного риска.'],
                'cardiovascular-risk' => ['status' => 'applicable', 'primary' => false, 'priority' => 40, 'reason' => 'Калий важен для сердечного ритма и cardiovascular risk context.'],
            ],

            'chloride' => [
                'general-adult' => ['status' => 'applicable', 'primary' => true, 'priority' => 10, 'reason' => 'Базовый профиль для оценки хлора как части электролитного баланса.'],
                'senior' => ['status' => 'applicable', 'primary' => false, 'priority' => 50, 'reason' => 'У пожилых электролитные нарушения чаще связаны с лекарствами, почками и гидратацией.'],
            ],

            'calcium-total' => [
                'general-adult' => ['status' => 'applicable', 'primary' => true, 'priority' => 10, 'reason' => 'Базовый профиль для общего кальция.'],
                'female-postmenopause' => ['status' => 'applicable', 'primary' => false, 'priority' => 30, 'reason' => 'После менопаузы кальций важен в контексте костного здоровья.'],
                'senior' => ['status' => 'applicable', 'primary' => false, 'priority' => 40, 'reason' => 'У пожилых кальций важен для костей, почек и общего метаболического риска.'],
                'longevity' => ['status' => 'applicable', 'primary' => false, 'priority' => 60, 'reason' => 'Кальций может быть полезен в longevity context вместе с витамином D и костным профилем.'],
            ],

            'magnesium' => [
                'general-adult' => ['status' => 'applicable', 'primary' => true, 'priority' => 10, 'reason' => 'Базовый профиль для магния.'],
                'cardiovascular-risk' => ['status' => 'applicable', 'primary' => false, 'priority' => 40, 'reason' => 'Магний важен в cardiovascular context, включая ритм и метаболические факторы.'],
                'insulin-resistance' => ['status' => 'applicable', 'primary' => false, 'priority' => 50, 'reason' => 'Магний может быть полезен в метаболическом контексте и insulin resistance.'],
                'athlete' => ['status' => 'applicable', 'primary' => false, 'priority' => 60, 'reason' => 'У спортсменов магний важен в контексте нагрузки, мышц и восстановления.'],
            ],

            'total-protein' => [
                'general-adult' => ['status' => 'applicable', 'primary' => true, 'priority' => 10, 'reason' => 'Базовый профиль для общего белка.'],
                'senior' => ['status' => 'applicable', 'primary' => false, 'priority' => 40, 'reason' => 'У пожилых общий белок важен в контексте питания, воспаления и хронических состояний.'],
            ],

            'albumin' => [
                'general-adult' => ['status' => 'applicable', 'primary' => true, 'priority' => 10, 'reason' => 'Базовый профиль для альбумина.'],
                'senior' => ['status' => 'applicable', 'primary' => false, 'priority' => 30, 'reason' => 'У пожилых альбумин важен как маркер питания, воспаления и общего риска.'],
                'longevity' => ['status' => 'applicable', 'primary' => false, 'priority' => 50, 'reason' => 'Альбумин может быть полезен в longevity context как общий health marker.'],
            ],

            'urea' => [
                'general-adult' => ['status' => 'applicable', 'primary' => true, 'priority' => 10, 'reason' => 'Базовый профиль для мочевины как почечно-метаболического маркера.'],
                'senior' => ['status' => 'applicable', 'primary' => false, 'priority' => 30, 'reason' => 'У пожилых мочевина важна в контексте почек, гидратации, питания и лекарств.'],
            ],

            'rbc' => [
                'general-adult' => ['status' => 'applicable', 'primary' => true, 'priority' => 10, 'reason' => 'Базовый профиль для оценки эритроцитов.'],
                'male-adult' => ['status' => 'applicable', 'primary' => false, 'priority' => 20, 'reason' => 'RBC зависит от пола и обычно имеет sex-specific ranges.'],
                'female-adult' => ['status' => 'applicable', 'primary' => false, 'priority' => 30, 'reason' => 'RBC зависит от пола и обычно имеет sex-specific ranges.'],
                'female-pregnant' => ['status' => 'applicable', 'primary' => false, 'priority' => 40, 'reason' => 'Беременность меняет интерпретацию показателей красной крови.'],
                'iron-deficiency-risk' => ['status' => 'applicable', 'primary' => false, 'priority' => 50, 'reason' => 'RBC важен в контексте анемии и дефицита железа.'],
            ],

            'hematocrit' => [
                'general-adult' => ['status' => 'applicable', 'primary' => true, 'priority' => 10, 'reason' => 'Базовый профиль для оценки доли клеток крови.'],
                'male-adult' => ['status' => 'applicable', 'primary' => false, 'priority' => 20, 'reason' => 'Гематокрит имеет выраженные sex-specific ranges.'],
                'female-adult' => ['status' => 'applicable', 'primary' => false, 'priority' => 30, 'reason' => 'Гематокрит имеет выраженные sex-specific ranges.'],
                'female-pregnant' => ['status' => 'applicable', 'primary' => false, 'priority' => 40, 'reason' => 'При беременности гематокрит требует отдельной интерпретации.'],
                'iron-deficiency-risk' => ['status' => 'applicable', 'primary' => false, 'priority' => 50, 'reason' => 'Гематокрит важен в оценке анемии и дефицитных состояний.'],
            ],

            'wbc' => [
                'general-adult' => ['status' => 'applicable', 'primary' => true, 'priority' => 10, 'reason' => 'Базовый профиль для оценки лейкоцитов.'],
                'female-pregnant' => ['status' => 'applicable', 'primary' => false, 'priority' => 30, 'reason' => 'При беременности лейкоциты могут интерпретироваться иначе.'],
                'senior' => ['status' => 'applicable', 'primary' => false, 'priority' => 50, 'reason' => 'У пожилых изменения WBC важны в контексте воспаления, инфекции и общего риска.'],
            ],

            'platelets' => [
                'general-adult' => ['status' => 'applicable', 'primary' => true, 'priority' => 10, 'reason' => 'Базовый профиль для оценки тромбоцитов.'],
                'female-pregnant' => ['status' => 'applicable', 'primary' => false, 'priority' => 30, 'reason' => 'При беременности тромбоциты требуют отдельного внимания.'],
                'senior' => ['status' => 'applicable', 'primary' => false, 'priority' => 50, 'reason' => 'У пожилых тромбоциты важны в контексте воспаления, кровотечений, тромбозов и лекарств.'],
            ],

            'serum-iron' => [
                'general-adult' => ['status' => 'applicable', 'primary' => true, 'priority' => 10, 'reason' => 'Базовый профиль для сывороточного железа.'],
                'female-adult' => ['status' => 'applicable', 'primary' => false, 'priority' => 30, 'reason' => 'У женщин чаще встречается дефицит железа из-за менструальных потерь.'],
                'female-pregnant' => ['status' => 'applicable', 'primary' => false, 'priority' => 40, 'reason' => 'При беременности потребность в железе меняется.'],
                'iron-deficiency-risk' => ['status' => 'applicable', 'primary' => false, 'priority' => 20, 'reason' => 'Сывороточное железо важно в iron deficiency context, но должно оцениваться вместе с ферритином и трансферрином.'],
            ],

            'free-t4' => [
                'general-adult' => ['status' => 'applicable', 'primary' => true, 'priority' => 10, 'reason' => 'Базовый профиль для свободного T4.'],
                'female-pregnant' => ['status' => 'applicable', 'primary' => false, 'priority' => 20, 'reason' => 'Беременность существенно меняет thyroid interpretation.'],
                'thyroid-risk' => ['status' => 'applicable', 'primary' => false, 'priority' => 15, 'reason' => 'Free T4 — ключевой marker при thyroid risk и отклонениях TSH.'],
                'senior' => ['status' => 'applicable', 'primary' => false, 'priority' => 40, 'reason' => 'У пожилых thyroid markers требуют более осторожной интерпретации.'],
            ],

            'free-t3' => [
                'general-adult' => ['status' => 'applicable', 'primary' => true, 'priority' => 10, 'reason' => 'Базовый профиль для свободного T3.'],
                'thyroid-risk' => ['status' => 'applicable', 'primary' => false, 'priority' => 15, 'reason' => 'Free T3 полезен в расширенной thyroid interpretation.'],
                'senior' => ['status' => 'applicable', 'primary' => false, 'priority' => 40, 'reason' => 'У пожилых thyroid markers требуют осторожной интерпретации.'],
            ],

            'bilirubin-total' => [
                'general-adult' => ['status' => 'applicable', 'primary' => true, 'priority' => 10, 'reason' => 'Базовый профиль для общего билирубина.'],
                'senior' => ['status' => 'applicable', 'primary' => false, 'priority' => 50, 'reason' => 'У пожилых билирубин важен в контексте печени, желчных путей, лекарств и сопутствующих состояний.'],
            ],

            'testosterone-total' => [
                'general-adult' => ['status' => 'needs_review', 'primary' => false, 'priority' => 80, 'reason' => 'Общие adult thresholds для тестостерона недостаточны без sex-specific logic.'],
                'male-adult' => ['status' => 'applicable', 'primary' => true, 'priority' => 10, 'reason' => 'Тестостерон имеет критически важную male-specific interpretation.'],
                'female-adult' => ['status' => 'applicable', 'primary' => false, 'priority' => 20, 'reason' => 'У женщин тестостерон важен в reproductive и metabolic context.'],
                'female-postmenopause' => ['status' => 'applicable', 'primary' => false, 'priority' => 40, 'reason' => 'После менопаузы androgen profile меняется.'],
                'athlete' => ['status' => 'applicable', 'primary' => false, 'priority' => 50, 'reason' => 'Тестостерон может быть важен в athlete recovery/performance context.'],
                'longevity' => ['status' => 'needs_review', 'primary' => false, 'priority' => 90, 'reason' => 'Longevity interpretation для testosterone требует отдельной validated methodology.'],
            ],

            'free-testosterone' => [
                'male-adult' => ['status' => 'applicable', 'primary' => true, 'priority' => 10, 'reason' => 'Свободный тестостерон часто более информативен для androgen status у мужчин.'],
                'female-adult' => ['status' => 'applicable', 'primary' => false, 'priority' => 20, 'reason' => 'У женщин free testosterone важен при hyperandrogenism context.'],
                'athlete' => ['status' => 'applicable', 'primary' => false, 'priority' => 40, 'reason' => 'Free testosterone может использоваться в athlete context.'],
            ],

            'estradiol' => [
                'female-adult' => ['status' => 'applicable', 'primary' => true, 'priority' => 10, 'reason' => 'Эстрадиол требует female-specific interpretation.'],
                'female-pregnant' => ['status' => 'applicable', 'primary' => false, 'priority' => 20, 'reason' => 'При беременности estradiol имеет отдельную физиологическую динамику.'],
                'female-postmenopause' => ['status' => 'applicable', 'primary' => false, 'priority' => 30, 'reason' => 'После менопаузы estradiol интерпретируется отдельно.'],
                'male-adult' => ['status' => 'needs_review', 'primary' => false, 'priority' => 80, 'reason' => 'Estradiol у мужчин требует аккуратной отдельной scoring logic.'],
            ],

            'progesterone' => [
                'female-adult' => ['status' => 'applicable', 'primary' => true, 'priority' => 10, 'reason' => 'Прогестерон требует female reproductive interpretation.'],
                'female-pregnant' => ['status' => 'applicable', 'primary' => false, 'priority' => 20, 'reason' => 'При беременности progesterone имеет отдельную физиологическую интерпретацию.'],
                'female-postmenopause' => ['status' => 'applicable', 'primary' => false, 'priority' => 40, 'reason' => 'После менопаузы progesterone profile меняется.'],
            ],

            'lh' => [
                'female-adult' => ['status' => 'applicable', 'primary' => true, 'priority' => 10, 'reason' => 'LH требует female reproductive interpretation.'],
                'male-adult' => ['status' => 'applicable', 'primary' => false, 'priority' => 20, 'reason' => 'LH важен для оценки male gonadal axis.'],
                'female-postmenopause' => ['status' => 'applicable', 'primary' => false, 'priority' => 30, 'reason' => 'После менопаузы LH физиологически меняется.'],
            ],

            'fsh' => [
                'female-adult' => ['status' => 'applicable', 'primary' => true, 'priority' => 10, 'reason' => 'FSH требует female reproductive interpretation.'],
                'male-adult' => ['status' => 'applicable', 'primary' => false, 'priority' => 20, 'reason' => 'FSH используется в male reproductive context.'],
                'female-postmenopause' => ['status' => 'applicable', 'primary' => false, 'priority' => 30, 'reason' => 'FSH значительно меняется после менопаузы.'],
            ],

            'prolactin' => [
                'female-adult' => ['status' => 'applicable', 'primary' => true, 'priority' => 10, 'reason' => 'Пролактин требует female hormonal interpretation.'],
                'male-adult' => ['status' => 'applicable', 'primary' => false, 'priority' => 20, 'reason' => 'Пролактин также значим в male endocrine context.'],
                'female-pregnant' => ['status' => 'applicable', 'primary' => false, 'priority' => 30, 'reason' => 'При беременности prolactin физиологически повышается.'],
            ],

            'cortisol' => [
                'general-adult' => ['status' => 'applicable', 'primary' => true, 'priority' => 10, 'reason' => 'Базовый профиль для кортизола.'],
                'athlete' => ['status' => 'applicable', 'primary' => false, 'priority' => 40, 'reason' => 'Кортизол может быть полезен в athlete recovery/stress context.'],
                'longevity' => ['status' => 'needs_review', 'primary' => false, 'priority' => 80, 'reason' => 'Longevity interpretation для cortisol требует validated methodology.'],
                'female-pregnant' => ['status' => 'needs_review', 'primary' => false, 'priority' => 90, 'reason' => 'Кортизол при беременности требует отдельной validated interpretation.'],
            ],

            'dhea-s' => [
                'general-adult' => ['status' => 'applicable', 'primary' => true, 'priority' => 10, 'reason' => 'Базовый профиль для DHEA-S.'],
                'female-adult' => ['status' => 'applicable', 'primary' => false, 'priority' => 20, 'reason' => 'DHEA-S важен в female androgen context.'],
                'male-adult' => ['status' => 'applicable', 'primary' => false, 'priority' => 30, 'reason' => 'DHEA-S участвует в male endocrine context.'],
                'longevity' => ['status' => 'needs_review', 'primary' => false, 'priority' => 80, 'reason' => 'DHEA-S часто обсуждается в longevity context, но требует validated scoring logic.'],
            ],

            'mcv' => [
                'general-adult' => ['status' => 'applicable', 'primary' => true, 'priority' => 10, 'reason' => 'Базовый профиль для MCV как индекса размера эритроцитов.'],
                'iron-deficiency-risk' => ['status' => 'applicable', 'primary' => false, 'priority' => 20, 'reason' => 'MCV важен для различения микроцитарной, нормоцитарной и макроцитарной анемии.'],
                'female-pregnant' => ['status' => 'applicable', 'primary' => false, 'priority' => 40, 'reason' => 'При беременности MCV важен в контексте дефицитов железа, B12 и фолата.'],
                'senior' => ['status' => 'applicable', 'primary' => false, 'priority' => 50, 'reason' => 'У пожилых MCV важен для выявления дефицитов и хронических состояний.'],
            ],

            'mch' => [
                'general-adult' => ['status' => 'applicable', 'primary' => true, 'priority' => 10, 'reason' => 'Базовый профиль для MCH как индекса содержания гемоглобина в эритроците.'],
                'iron-deficiency-risk' => ['status' => 'applicable', 'primary' => false, 'priority' => 20, 'reason' => 'MCH помогает оценивать гипохромию и iron deficiency context.'],
                'female-pregnant' => ['status' => 'applicable', 'primary' => false, 'priority' => 40, 'reason' => 'При беременности MCH полезен в контексте дефицитных анемий.'],
            ],

            'mchc' => [
                'general-adult' => ['status' => 'applicable', 'primary' => true, 'priority' => 10, 'reason' => 'Базовый профиль для MCHC как индекса концентрации гемоглобина в эритроцитах.'],
                'iron-deficiency-risk' => ['status' => 'applicable', 'primary' => false, 'priority' => 20, 'reason' => 'MCHC помогает оценивать гипохромные состояния и iron deficiency context.'],
            ],

            'rdw' => [
                'general-adult' => ['status' => 'applicable', 'primary' => true, 'priority' => 10, 'reason' => 'Базовый профиль для RDW как показателя вариабельности размеров эритроцитов.'],
                'iron-deficiency-risk' => ['status' => 'applicable', 'primary' => false, 'priority' => 20, 'reason' => 'RDW часто важен при раннем дефиците железа и смешанных анемиях.'],
                'senior' => ['status' => 'applicable', 'primary' => false, 'priority' => 50, 'reason' => 'У пожилых RDW может быть полезен как общий marker риска и дефицитных состояний.'],
            ],

            'neutrophils' => [
                'general-adult' => ['status' => 'applicable', 'primary' => true, 'priority' => 10, 'reason' => 'Базовый профиль для нейтрофилов как части лейкоцитарной формулы.'],
                'senior' => ['status' => 'applicable', 'primary' => false, 'priority' => 40, 'reason' => 'У пожилых изменения нейтрофилов важны в контексте инфекции, воспаления и лекарств.'],
                'female-pregnant' => ['status' => 'applicable', 'primary' => false, 'priority' => 50, 'reason' => 'При беременности нейтрофилы могут иметь физиологически иной контекст.'],
            ],

            'lymphocytes' => [
                'general-adult' => ['status' => 'applicable', 'primary' => true, 'priority' => 10, 'reason' => 'Базовый профиль для лимфоцитов как части иммунного статуса.'],
                'senior' => ['status' => 'applicable', 'primary' => false, 'priority' => 40, 'reason' => 'У пожилых лимфоциты важны в контексте иммунного старения, инфекций и хронических состояний.'],
            ],

            'monocytes' => [
                'general-adult' => ['status' => 'applicable', 'primary' => true, 'priority' => 10, 'reason' => 'Базовый профиль для моноцитов как части лейкоцитарной формулы.'],
                'senior' => ['status' => 'applicable', 'primary' => false, 'priority' => 50, 'reason' => 'У пожилых моноциты могут быть важны в контексте хронического воспаления.'],
            ],

            'eosinophils' => [
                'general-adult' => ['status' => 'applicable', 'primary' => true, 'priority' => 10, 'reason' => 'Базовый профиль для эозинофилов.'],
                'senior' => ['status' => 'needs_review', 'primary' => false, 'priority' => 80, 'reason' => 'Возрастной контекст возможен, но scoring logic для senior требует review.'],
            ],

            'basophils' => [
                'general-adult' => ['status' => 'applicable', 'primary' => true, 'priority' => 10, 'reason' => 'Базовый профиль для базофилов как части лейкоцитарной формулы.'],
            ],

            'transferrin' => [
                'general-adult' => ['status' => 'applicable', 'primary' => true, 'priority' => 10, 'reason' => 'Базовый профиль для трансферрина как транспортного белка железа.'],
                'iron-deficiency-risk' => ['status' => 'applicable', 'primary' => true, 'priority' => 5, 'reason' => 'Трансферрин критически важен для оценки iron deficiency context вместе с ferritin и serum iron.'],
                'female-adult' => ['status' => 'applicable', 'primary' => false, 'priority' => 30, 'reason' => 'У женщин дефицит железа встречается чаще.'],
                'female-pregnant' => ['status' => 'applicable', 'primary' => false, 'priority' => 40, 'reason' => 'При беременности транспорт железа и iron demand существенно меняются.'],
            ],

            'transferrin-saturation' => [
                'general-adult' => ['status' => 'applicable', 'primary' => false, 'priority' => 20, 'reason' => 'Насыщение трансферрина полезно для оценки iron metabolism.'],
                'iron-deficiency-risk' => ['status' => 'applicable', 'primary' => true, 'priority' => 5, 'reason' => 'Насыщение трансферрина — один из ключевых markers iron deficiency.'],
                'female-pregnant' => ['status' => 'applicable', 'primary' => false, 'priority' => 40, 'reason' => 'При беременности saturation interpretation требует отдельного контекста.'],
            ],

            'tibc' => [
                'general-adult' => ['status' => 'applicable', 'primary' => false, 'priority' => 30, 'reason' => 'TIBC помогает оценивать транспорт и дефицит железа.'],
                'iron-deficiency-risk' => ['status' => 'applicable', 'primary' => true, 'priority' => 10, 'reason' => 'TIBC особенно важен при iron deficiency interpretation.'],
            ],

            'uibc' => [
                'general-adult' => ['status' => 'needs_review', 'primary' => false, 'priority' => 80, 'reason' => 'UIBC используется не во всех lab flows и требует отдельной validation strategy.'],
                'iron-deficiency-risk' => ['status' => 'applicable', 'primary' => true, 'priority' => 20, 'reason' => 'UIBC может быть полезен в расширенном iron deficiency context.'],
            ],

            'reticulocytes' => [
                'general-adult' => ['status' => 'applicable', 'primary' => false, 'priority' => 40, 'reason' => 'Ретикулоциты используются для оценки активности эритропоэза.'],
                'iron-deficiency-risk' => ['status' => 'applicable', 'primary' => true, 'priority' => 10, 'reason' => 'Ретикулоциты важны в differential interpretation анемии.'],
                'female-pregnant' => ['status' => 'needs_review', 'primary' => false, 'priority' => 85, 'reason' => 'Ретикулоциты при беременности требуют отдельной validated interpretation.'],
            ],

            'homocysteine' => [
                'general-adult' => ['status' => 'applicable', 'primary' => false, 'priority' => 40, 'reason' => 'Гомоцистеин может использоваться как расширенный metabolic marker.'],
                'cardiovascular-risk' => ['status' => 'applicable', 'primary' => true, 'priority' => 10, 'reason' => 'Гомоцистеин связан с cardiovascular risk context.'],
                'vitamin-deficiency-risk' => ['status' => 'applicable', 'primary' => false, 'priority' => 20, 'reason' => 'Гомоцистеин важен при дефиците B12 и фолата.'],
                'longevity' => ['status' => 'needs_review', 'primary' => false, 'priority' => 80, 'reason' => 'Longevity interpretation для homocysteine требует validated methodology.'],
            ],

            'apo-b' => [
                'general-adult' => ['status' => 'applicable', 'primary' => false, 'priority' => 30, 'reason' => 'ApoB используется как расширенный lipid marker.'],
                'cardiovascular-risk' => ['status' => 'applicable', 'primary' => true, 'priority' => 10, 'reason' => 'ApoB является одним из ключевых markers cardiovascular risk.'],
                'insulin-resistance' => ['status' => 'applicable', 'primary' => false, 'priority' => 30, 'reason' => 'ApoB полезен в atherogenic/metabolic context.'],
            ],

            'lp-a' => [
                'general-adult' => ['status' => 'needs_review', 'primary' => false, 'priority' => 80, 'reason' => 'Lp(a) не должен интерпретироваться как обычный lipid marker без отдельной strategy.'],
                'cardiovascular-risk' => ['status' => 'applicable', 'primary' => true, 'priority' => 5, 'reason' => 'Lp(a) — важный inherited cardiovascular risk marker.'],
                'longevity' => ['status' => 'needs_review', 'primary' => false, 'priority' => 90, 'reason' => 'Longevity logic для Lp(a) требует отдельной validation.'],
            ],

            'anti-tpo' => [
                'general-adult' => ['status' => 'applicable', 'primary' => false, 'priority' => 30, 'reason' => 'Anti-TPO используется как autoimmune thyroid marker.'],
                'thyroid-risk' => ['status' => 'applicable', 'primary' => true, 'priority' => 5, 'reason' => 'Anti-TPO — один из ключевых markers autoimmune thyroid disease.'],
                'female-adult' => ['status' => 'applicable', 'primary' => false, 'priority' => 20, 'reason' => 'Autoimmune thyroid disorders чаще встречаются у женщин.'],
                'female-pregnant' => ['status' => 'applicable', 'primary' => false, 'priority' => 25, 'reason' => 'Thyroid autoimmunity важна в pregnancy context.'],
            ],

            'anti-tg' => [
                'general-adult' => ['status' => 'applicable', 'primary' => false, 'priority' => 40, 'reason' => 'Anti-TG используется как дополнительный autoimmune thyroid marker.'],
                'thyroid-risk' => ['status' => 'applicable', 'primary' => true, 'priority' => 10, 'reason' => 'Anti-TG важен в расширенном thyroid autoimmune context.'],
                'female-adult' => ['status' => 'applicable', 'primary' => false, 'priority' => 30, 'reason' => 'Autoimmune thyroid disorders чаще встречаются у женщин.'],
            ],

            'trab' => [
                'general-adult' => ['status' => 'needs_review', 'primary' => false, 'priority' => 85, 'reason' => 'TRAb требует disease-specific interpretation strategy.'],
                'thyroid-risk' => ['status' => 'applicable', 'primary' => true, 'priority' => 5, 'reason' => 'TRAb критически важен для Graves disease context.'],
                'female-pregnant' => ['status' => 'needs_review', 'primary' => false, 'priority' => 90, 'reason' => 'TRAb при беременности требует отдельной validated interpretation.'],
            ],

            'hs-crp' => [
                'general-adult' => ['status' => 'applicable', 'primary' => false, 'priority' => 30, 'reason' => 'hs-CRP используется как high-sensitivity inflammation marker.'],
                'cardiovascular-risk' => ['status' => 'applicable', 'primary' => true, 'priority' => 5, 'reason' => 'hs-CRP особенно важен в cardiovascular risk context.'],
                'insulin-resistance' => ['status' => 'applicable', 'primary' => false, 'priority' => 20, 'reason' => 'hs-CRP может отражать chronic low-grade inflammation при metabolic risk.'],
                'longevity' => ['status' => 'needs_review', 'primary' => false, 'priority' => 80, 'reason' => 'Longevity interpretation для hs-CRP требует validated methodology.'],
            ],

            'procalcitonin' => [
                'general-adult' => ['status' => 'needs_review', 'primary' => false, 'priority' => 80, 'reason' => 'Прокальцитонин требует acute-clinical interpretation strategy, а не general wellness scoring.'],
                'senior' => ['status' => 'needs_review', 'primary' => false, 'priority' => 85, 'reason' => 'У пожилых interpretation зависит от acute clinical context.'],
            ],

            'albumin-creatinine-ratio' => [
                'general-adult' => ['status' => 'applicable', 'primary' => false, 'priority' => 40, 'reason' => 'ACR используется как kidney damage marker.'],
                'cardiovascular-risk' => ['status' => 'applicable', 'primary' => true, 'priority' => 10, 'reason' => 'ACR важен в cardiovascular и renal risk context.'],
                'insulin-resistance' => ['status' => 'applicable', 'primary' => false, 'priority' => 20, 'reason' => 'ACR полезен при metabolic risk и diabetes-related kidney assessment.'],
                'senior' => ['status' => 'applicable', 'primary' => false, 'priority' => 30, 'reason' => 'У пожилых ACR важен для ранней оценки kidney damage.'],
            ],

            'c-peptide' => [
                'general-adult' => ['status' => 'applicable', 'primary' => false, 'priority' => 40, 'reason' => 'C-peptide используется как расширенный metabolic marker.'],
                'insulin-resistance' => ['status' => 'applicable', 'primary' => true, 'priority' => 10, 'reason' => 'C-peptide важен для оценки insulin production и metabolic context.'],
                'cardiovascular-risk' => ['status' => 'applicable', 'primary' => false, 'priority' => 30, 'reason' => 'Hyperinsulinemic context может быть связан с cardiovascular risk.'],
            ],
                        
            'ck' => [
                'general-adult' => ['status' => 'applicable', 'primary' => false, 'priority' => 30, 'reason' => 'CK используется как marker мышечного повреждения и нагрузки.'],
                'athlete' => ['status' => 'applicable', 'primary' => true, 'priority' => 5, 'reason' => 'CK особенно важен в athlete recovery/training context.'],
                'male-adult' => ['status' => 'applicable', 'primary' => false, 'priority' => 20, 'reason' => 'CK имеет sex-specific особенности из-за различий мышечной массы.'],
                'senior' => ['status' => 'needs_review', 'primary' => false, 'priority' => 80, 'reason' => 'CK у пожилых требует осторожной интерпретации с учётом sarcopenia и comorbidity.'],
            ],

            'ldh' => [
                'general-adult' => ['status' => 'applicable', 'primary' => true, 'priority' => 10, 'reason' => 'LDH используется как неспецифический marker tissue turnover и повреждения тканей.'],
                'senior' => ['status' => 'applicable', 'primary' => false, 'priority' => 40, 'reason' => 'У пожилых LDH может отражать широкий спектр tissue stress contexts.'],
            ],

            'alkaline-phosphatase' => [
                'general-adult' => ['status' => 'applicable', 'primary' => true, 'priority' => 10, 'reason' => 'ALP важен для liver/biliary и bone context.'],
                'female-postmenopause' => ['status' => 'applicable', 'primary' => false, 'priority' => 20, 'reason' => 'После менопаузы ALP может быть связан с bone turnover context.'],
                'senior' => ['status' => 'applicable', 'primary' => false, 'priority' => 30, 'reason' => 'У пожилых ALP требует интерпретации в liver/bone context.'],
                'vitamin-deficiency-risk' => ['status' => 'applicable', 'primary' => false, 'priority' => 50, 'reason' => 'ALP может быть полезен в bone/mineral deficiency context.'],
            ],

            'nt-probnp' => [
                'general-adult' => ['status' => 'needs_review', 'primary' => false, 'priority' => 85, 'reason' => 'NT-proBNP требует age-adjusted cardiovascular interpretation strategy.'],
                'cardiovascular-risk' => ['status' => 'applicable', 'primary' => true, 'priority' => 5, 'reason' => 'NT-proBNP важен для cardiovascular stress и heart failure context.'],
                'senior' => ['status' => 'applicable', 'primary' => false, 'priority' => 15, 'reason' => 'У пожилых NT-proBNP особенно важен, но требует age-aware interpretation.'],
            ],

            'troponin-i' => [
                'general-adult' => ['status' => 'needs_review', 'primary' => false, 'priority' => 95, 'reason' => 'Troponin I требует acute cardiac interpretation, а не wellness scoring.'],
                'cardiovascular-risk' => ['status' => 'needs_review', 'primary' => false, 'priority' => 90, 'reason' => 'Troponin требует acute clinical context even in cardiovascular-risk users.'],
            ],

            'troponin-t' => [
                'general-adult' => ['status' => 'needs_review', 'primary' => false, 'priority' => 95, 'reason' => 'Troponin T требует acute cardiac interpretation strategy.'],
                'cardiovascular-risk' => ['status' => 'needs_review', 'primary' => false, 'priority' => 90, 'reason' => 'Troponin T не должен интерпретироваться как обычный wellness marker.'],
            ],

            'bilirubin-direct' => [
                'general-adult' => ['status' => 'applicable', 'primary' => true, 'priority' => 10, 'reason' => 'Direct bilirubin важен для liver/biliary interpretation.'],
                'senior' => ['status' => 'applicable', 'primary' => false, 'priority' => 40, 'reason' => 'У пожилых bilirubin interpretation требует liver/biliary context.'],
            ],

            'bilirubin-indirect' => [
                'general-adult' => ['status' => 'applicable', 'primary' => true, 'priority' => 10, 'reason' => 'Indirect bilirubin важен для hemolysis/liver interpretation.'],
                'iron-deficiency-risk' => ['status' => 'needs_review', 'primary' => false, 'priority' => 75, 'reason' => 'Indirect bilirubin может пересекаться с hematologic interpretation, но требует careful logic.'],
            ],

            'lipoprotein-associated-phospholipase-a2' => [
                'general-adult' => ['status' => 'needs_review', 'primary' => false, 'priority' => 85, 'reason' => 'Lp-PLA2 требует advanced cardiovascular scoring strategy.'],
                'cardiovascular-risk' => ['status' => 'applicable', 'primary' => true, 'priority' => 10, 'reason' => 'Lp-PLA2 используется как advanced vascular inflammation marker.'],
                'longevity' => ['status' => 'needs_review', 'primary' => false, 'priority' => 90, 'reason' => 'Longevity interpretation для Lp-PLA2 требует validated methodology.'],
            ],

            'phosphorus' => [
                'general-adult' => ['status' => 'applicable', 'primary' => true, 'priority' => 10, 'reason' => 'Фосфор важен для mineral/bone metabolism.'],
                'senior' => ['status' => 'applicable', 'primary' => false, 'priority' => 30, 'reason' => 'У пожилых phosphorus важен в bone/kidney context.'],
                'female-postmenopause' => ['status' => 'applicable', 'primary' => false, 'priority' => 40, 'reason' => 'После менопаузы mineral metabolism становится более значимым.'],
            ],

            'parathyroid-hormone' => [
                'general-adult' => ['status' => 'applicable', 'primary' => false, 'priority' => 40, 'reason' => 'PTH используется как расширенный marker calcium metabolism.'],
                'female-postmenopause' => ['status' => 'applicable', 'primary' => true, 'priority' => 10, 'reason' => 'PTH особенно важен в bone/postmenopause context.'],
                'senior' => ['status' => 'applicable', 'primary' => false, 'priority' => 20, 'reason' => 'У пожилых PTH важен для оценки mineral metabolism и bone risk.'],
                'vitamin-deficiency-risk' => ['status' => 'applicable', 'primary' => false, 'priority' => 30, 'reason' => 'PTH важен в vitamin D/calcium deficiency context.'],
            ],

            'ionized-calcium' => [
                'general-adult' => ['status' => 'applicable', 'primary' => true, 'priority' => 10, 'reason' => 'Ionized calcium отражает физиологически активный кальций.'],
                'senior' => ['status' => 'applicable', 'primary' => false, 'priority' => 30, 'reason' => 'У пожилых ionized calcium важен в bone/kidney context.'],
                'female-postmenopause' => ['status' => 'applicable', 'primary' => false, 'priority' => 40, 'reason' => 'После менопаузы calcium regulation становится более значимой.'],
            ],

            'zinc' => [
                'general-adult' => ['status' => 'applicable', 'primary' => false, 'priority' => 40, 'reason' => 'Цинк используется как расширенный nutritional marker.'],
                'vitamin-deficiency-risk' => ['status' => 'applicable', 'primary' => true, 'priority' => 10, 'reason' => 'Zinc важен в deficiency/nutrition context.'],
                'athlete' => ['status' => 'applicable', 'primary' => false, 'priority' => 30, 'reason' => 'У спортсменов zinc может быть важен в recovery/performance context.'],
            ],

            'copper' => [
                'general-adult' => ['status' => 'applicable', 'primary' => false, 'priority' => 50, 'reason' => 'Copper используется как расширенный mineral marker.'],
                'iron-deficiency-risk' => ['status' => 'applicable', 'primary' => false, 'priority' => 20, 'reason' => 'Copper может пересекаться с hematologic/iron metabolism context.'],
                'vitamin-deficiency-risk' => ['status' => 'applicable', 'primary' => true, 'priority' => 10, 'reason' => 'Copper важен в deficiency/nutrition context.'],
            ],

            'selenium' => [
                'general-adult' => ['status' => 'applicable', 'primary' => false, 'priority' => 50, 'reason' => 'Selenium используется как расширенный nutritional marker.'],
                'thyroid-risk' => ['status' => 'applicable', 'primary' => true, 'priority' => 10, 'reason' => 'Selenium связан с thyroid function и thyroid autoimmunity context.'],
                'vitamin-deficiency-risk' => ['status' => 'applicable', 'primary' => false, 'priority' => 20, 'reason' => 'Selenium важен в nutritional deficiency context.'],
            ],

            'osteocalcin' => [
                'general-adult' => ['status' => 'needs_review', 'primary' => false, 'priority' => 85, 'reason' => 'Osteocalcin требует отдельной bone-metabolism scoring strategy.'],
                'female-postmenopause' => ['status' => 'applicable', 'primary' => true, 'priority' => 10, 'reason' => 'Osteocalcin может быть полезен в postmenopause bone-turnover context.'],
                'senior' => ['status' => 'applicable', 'primary' => false, 'priority' => 20, 'reason' => 'У пожилых osteocalcin связан с bone metabolism context.'],
            ],

            'ctx' => [
                'general-adult' => ['status' => 'needs_review', 'primary' => false, 'priority' => 90, 'reason' => 'CTX требует отдельной validated bone-turnover interpretation strategy.'],
                'female-postmenopause' => ['status' => 'applicable', 'primary' => true, 'priority' => 10, 'reason' => 'CTX особенно важен в postmenopause bone resorption context.'],
                'senior' => ['status' => 'applicable', 'primary' => false, 'priority' => 20, 'reason' => 'CTX может быть полезен в age-related bone turnover context.'],
            ],

            'p1np' => [
                'general-adult' => ['status' => 'needs_review', 'primary' => false, 'priority' => 90, 'reason' => 'P1NP требует отдельной bone-turnover scoring methodology.'],
                'female-postmenopause' => ['status' => 'applicable', 'primary' => true, 'priority' => 10, 'reason' => 'P1NP важен в bone formation/postmenopause context.'],
                'senior' => ['status' => 'applicable', 'primary' => false, 'priority' => 20, 'reason' => 'P1NP может использоваться в age-related bone metabolism context.'],
            ],

            'igf-1' => [
                'general-adult' => ['status' => 'needs_review', 'primary' => false, 'priority' => 85, 'reason' => 'IGF-1 требует отдельной endocrine/longevity interpretation strategy.'],
                'longevity' => ['status' => 'applicable', 'primary' => true, 'priority' => 10, 'reason' => 'IGF-1 часто используется в longevity/metabolic context.'],
                'athlete' => ['status' => 'applicable', 'primary' => false, 'priority' => 30, 'reason' => 'IGF-1 может использоваться в recovery/performance context.'],
            ],

            'growth-hormone' => [
                'general-adult' => ['status' => 'needs_review', 'primary' => false, 'priority' => 95, 'reason' => 'Growth hormone требует highly specialized endocrine interpretation.'],
                'longevity' => ['status' => 'needs_review', 'primary' => false, 'priority' => 90, 'reason' => 'Longevity interpretation для GH требует validated methodology.'],
            ],

            'fasting-glucose' => [
                'general-adult' => ['status' => 'applicable', 'primary' => true, 'priority' => 10, 'reason' => 'Fasting glucose — базовый metabolic marker.'],
                'insulin-resistance' => ['status' => 'applicable', 'primary' => true, 'priority' => 5, 'reason' => 'Fasting glucose критически важен для insulin resistance context.'],
                'cardiovascular-risk' => ['status' => 'applicable', 'primary' => false, 'priority' => 20, 'reason' => 'Glucose metabolism тесно связан с cardiovascular risk.'],
                'female-pregnant' => ['status' => 'applicable', 'primary' => false, 'priority' => 30, 'reason' => 'Fasting glucose важен в pregnancy metabolic context.'],
            ],

            'postprandial-glucose' => [
                'general-adult' => ['status' => 'applicable', 'primary' => false, 'priority' => 40, 'reason' => 'Postprandial glucose используется как расширенный metabolic marker.'],
                'insulin-resistance' => ['status' => 'applicable', 'primary' => true, 'priority' => 10, 'reason' => 'Postprandial glucose важен для ранних metabolic abnormalities.'],
                'cardiovascular-risk' => ['status' => 'applicable', 'primary' => false, 'priority' => 30, 'reason' => 'Postprandial hyperglycemia связана с cardiovascular risk.'],
            ],

            'fasting-insulin' => [
                'general-adult' => ['status' => 'applicable', 'primary' => false, 'priority' => 30, 'reason' => 'Fasting insulin используется как расширенный metabolic marker.'],
                'insulin-resistance' => ['status' => 'applicable', 'primary' => true, 'priority' => 5, 'reason' => 'Fasting insulin является ключевым marker insulin resistance.'],
                'cardiovascular-risk' => ['status' => 'applicable', 'primary' => false, 'priority' => 20, 'reason' => 'Hyperinsulinemia может быть связана с cardiovascular risk.'],
            ],

            'apo-a1' => [
                'general-adult' => ['status' => 'applicable', 'primary' => false, 'priority' => 40, 'reason' => 'ApoA1 используется как расширенный lipid marker.'],
                'cardiovascular-risk' => ['status' => 'applicable', 'primary' => true, 'priority' => 10, 'reason' => 'ApoA1 важен в расширенном cardiovascular lipid context.'],
                'longevity' => ['status' => 'needs_review', 'primary' => false, 'priority' => 80, 'reason' => 'Longevity interpretation для ApoA1 требует validated methodology.'],
            ],

            'non-hdl-cholesterol' => [
                'general-adult' => ['status' => 'applicable', 'primary' => true, 'priority' => 10, 'reason' => 'Non-HDL cholesterol — полезный aggregated lipid marker.'],
                'cardiovascular-risk' => ['status' => 'applicable', 'primary' => true, 'priority' => 5, 'reason' => 'Non-HDL cholesterol важен для atherogenic risk assessment.'],
                'insulin-resistance' => ['status' => 'applicable', 'primary' => false, 'priority' => 20, 'reason' => 'Non-HDL cholesterol полезен в metabolic dyslipidemia context.'],
            ],

            'sd-ldl' => [
                'general-adult' => ['status' => 'needs_review', 'primary' => false, 'priority' => 85, 'reason' => 'sd-LDL требует advanced lipid interpretation strategy.'],
                'cardiovascular-risk' => ['status' => 'applicable', 'primary' => true, 'priority' => 10, 'reason' => 'sd-LDL используется как advanced atherogenic marker.'],
                'insulin-resistance' => ['status' => 'applicable', 'primary' => false, 'priority' => 20, 'reason' => 'sd-LDL часто связан с insulin resistance и metabolic syndrome.'],
            ],

            'omega-3-index' => [
                'general-adult' => ['status' => 'needs_review', 'primary' => false, 'priority' => 85, 'reason' => 'Omega-3 index требует отдельной preventive/longevity scoring methodology.'],
                'cardiovascular-risk' => ['status' => 'applicable', 'primary' => true, 'priority' => 20, 'reason' => 'Omega-3 index может использоваться в cardiovascular preventive context.'],
                'longevity' => ['status' => 'applicable', 'primary' => false, 'priority' => 30, 'reason' => 'Omega-3 index часто используется в longevity/preventive context.'],
            ],

            'fecal-calprotectin' => [
                'general-adult' => ['status' => 'needs_review', 'primary' => false, 'priority' => 90, 'reason' => 'Fecal calprotectin требует GI-specific inflammatory interpretation strategy.'],
                'autoimmune-risk' => ['status' => 'applicable', 'primary' => true, 'priority' => 10, 'reason' => 'Calprotectin важен в autoimmune/inflammatory bowel context.'],
            ],

            'celiac-antibodies' => [
                'general-adult' => ['status' => 'needs_review', 'primary' => false, 'priority' => 90, 'reason' => 'Celiac antibodies требуют disease-specific interpretation.'],
                'vitamin-deficiency-risk' => ['status' => 'applicable', 'primary' => true, 'priority' => 10, 'reason' => 'Celiac disease может быть причиной iron/B12/folate deficiency.'],
                'autoimmune-risk' => ['status' => 'applicable', 'primary' => false, 'priority' => 20, 'reason' => 'Celiac disease относится к autoimmune spectrum context.'],
            ],

            'anti-ttg-iga' => [
                'general-adult' => ['status' => 'needs_review', 'primary' => false, 'priority' => 90, 'reason' => 'Anti-tTG IgA требует celiac-specific interpretation strategy.'],
                'vitamin-deficiency-risk' => ['status' => 'applicable', 'primary' => true, 'priority' => 5, 'reason' => 'Anti-tTG IgA важен при unexplained nutritional deficiencies.'],
                'autoimmune-risk' => ['status' => 'applicable', 'primary' => false, 'priority' => 20, 'reason' => 'Celiac autoimmunity входит в autoimmune-risk context.'],
            ],

            'total-iga' => [
                'general-adult' => ['status' => 'applicable', 'primary' => false, 'priority' => 50, 'reason' => 'Total IgA используется как supporting immunologic marker.'],
                'autoimmune-risk' => ['status' => 'applicable', 'primary' => true, 'priority' => 20, 'reason' => 'Total IgA важен для корректной interpretation autoimmune serology.'],
            ],

            'lipoprotein-insulin-resistance-score' => [
                'general-adult' => ['status' => 'needs_review', 'primary' => false, 'priority' => 85, 'reason' => 'LPIR требует advanced metabolic scoring methodology.'],
                'insulin-resistance' => ['status' => 'applicable', 'primary' => true, 'priority' => 5, 'reason' => 'LPIR используется как advanced insulin resistance marker.'],
                'cardiovascular-risk' => ['status' => 'applicable', 'primary' => false, 'priority' => 20, 'reason' => 'LPIR связан с cardiometabolic risk context.'],
            ],

            'leptin' => [
                'general-adult' => ['status' => 'needs_review', 'primary' => false, 'priority' => 85, 'reason' => 'Leptin требует obesity/metabolic-specific interpretation strategy.'],
                'insulin-resistance' => ['status' => 'applicable', 'primary' => true, 'priority' => 10, 'reason' => 'Leptin связан с adiposity и insulin resistance context.'],
                'longevity' => ['status' => 'needs_review', 'primary' => false, 'priority' => 90, 'reason' => 'Longevity interpretation для leptin требует validated methodology.'],
            ],

            'adiponectin' => [
                'general-adult' => ['status' => 'needs_review', 'primary' => false, 'priority' => 85, 'reason' => 'Adiponectin требует advanced metabolic interpretation.'],
                'insulin-resistance' => ['status' => 'applicable', 'primary' => true, 'priority' => 10, 'reason' => 'Adiponectin важен в insulin sensitivity/metabolic context.'],
                'cardiovascular-risk' => ['status' => 'applicable', 'primary' => false, 'priority' => 20, 'reason' => 'Adiponectin может использоваться в cardiometabolic context.'],
            ],

            'gamma-globulins' => [
                'general-adult' => ['status' => 'applicable', 'primary' => false, 'priority' => 40, 'reason' => 'Gamma globulins используются как broad immune/inflammatory marker.'],
                'autoimmune-risk' => ['status' => 'applicable', 'primary' => true, 'priority' => 15, 'reason' => 'Gamma globulins могут быть важны в autoimmune/inflammatory context.'],
                'senior' => ['status' => 'applicable', 'primary' => false, 'priority' => 30, 'reason' => 'У пожилых gamma globulins важны в chronic inflammatory/immune context.'],
            ],

            'immunoglobulin-g' => [
                'general-adult' => ['status' => 'applicable', 'primary' => false, 'priority' => 50, 'reason' => 'IgG используется как расширенный immune marker.'],
                'autoimmune-risk' => ['status' => 'applicable', 'primary' => true, 'priority' => 10, 'reason' => 'IgG важен в autoimmune/inflammatory context.'],
            ],

            'immunoglobulin-a' => [
                'general-adult' => ['status' => 'applicable', 'primary' => false, 'priority' => 50, 'reason' => 'IgA используется как расширенный immune marker.'],
                'autoimmune-risk' => ['status' => 'applicable', 'primary' => true, 'priority' => 10, 'reason' => 'IgA важен в mucosal/autoimmune context.'],
            ],

            'immunoglobulin-m' => [
                'general-adult' => ['status' => 'applicable', 'primary' => false, 'priority' => 50, 'reason' => 'IgM используется как расширенный immune marker.'],
                'autoimmune-risk' => ['status' => 'applicable', 'primary' => true, 'priority' => 10, 'reason' => 'IgM может быть важен в autoimmune/inflammatory context.'],
            ],

            'hepcidin' => [
                'general-adult' => ['status' => 'needs_review', 'primary' => false, 'priority' => 90, 'reason' => 'Hepcidin требует advanced iron-regulation interpretation strategy.'],
                'iron-deficiency-risk' => ['status' => 'applicable', 'primary' => true, 'priority' => 5, 'reason' => 'Hepcidin является ключевым regulator marker в iron metabolism context.'],
                'chronic-inflammation-risk' => ['status' => 'applicable', 'primary' => false, 'priority' => 20, 'reason' => 'Hepcidin важен в anemia of chronic inflammation context.'],
            ],

            'soluble-transferrin-receptor' => [
                'general-adult' => ['status' => 'applicable', 'primary' => false, 'priority' => 40, 'reason' => 'sTfR используется как расширенный iron metabolism marker.'],
                'iron-deficiency-risk' => ['status' => 'applicable', 'primary' => true, 'priority' => 5, 'reason' => 'sTfR помогает differentiating iron deficiency vs inflammation-related anemia.'],
            ],

            'reticulocyte-hemoglobin' => [
                'general-adult' => ['status' => 'needs_review', 'primary' => false, 'priority' => 80, 'reason' => 'Reticulocyte hemoglobin требует advanced hematology interpretation.'],
                'iron-deficiency-risk' => ['status' => 'applicable', 'primary' => true, 'priority' => 10, 'reason' => 'Reticulocyte hemoglobin полезен для раннего iron deficiency detection.'],
            ],

            'interleukin-6' => [
                'general-adult' => ['status' => 'needs_review', 'primary' => false, 'priority' => 90, 'reason' => 'IL-6 требует inflammatory/cytokine-specific interpretation strategy.'],
                'chronic-inflammation-risk' => ['status' => 'applicable', 'primary' => true, 'priority' => 10, 'reason' => 'IL-6 является ключевым inflammatory cytokine marker.'],
                'cardiovascular-risk' => ['status' => 'applicable', 'primary' => false, 'priority' => 25, 'reason' => 'IL-6 может быть связан с vascular inflammation context.'],
                'longevity' => ['status' => 'needs_review', 'primary' => false, 'priority' => 85, 'reason' => 'Longevity interpretation для IL-6 требует validated methodology.'],
            ],

            'tnf-alpha' => [
                'general-adult' => ['status' => 'needs_review', 'primary' => false, 'priority' => 90, 'reason' => 'TNF-alpha требует cytokine-specific inflammatory interpretation.'],
                'chronic-inflammation-risk' => ['status' => 'applicable', 'primary' => true, 'priority' => 10, 'reason' => 'TNF-alpha важен в chronic inflammatory context.'],
                'autoimmune-risk' => ['status' => 'applicable', 'primary' => false, 'priority' => 20, 'reason' => 'TNF-alpha может быть важен в autoimmune inflammatory context.'],
            ],

            'ferritin-crp-index' => [
                'general-adult' => ['status' => 'needs_review', 'primary' => false, 'priority' => 95, 'reason' => 'Ferritin-CRP index требует custom derived-marker methodology.'],
                'iron-deficiency-risk' => ['status' => 'applicable', 'primary' => true, 'priority' => 10, 'reason' => 'Ferritin-CRP relationship важен для differentiating deficiency vs inflammation.'],
                'chronic-inflammation-risk' => ['status' => 'applicable', 'primary' => false, 'priority' => 20, 'reason' => 'Ferritin/CRP interplay важен в inflammatory iron metabolism context.'],
            ],

            'pulse-wave-velocity' => [
                'general-adult' => ['status' => 'needs_review', 'primary' => false, 'priority' => 95, 'reason' => 'PWV требует vascular-aging specific methodology.'],
                'cardiovascular-risk' => ['status' => 'applicable', 'primary' => true, 'priority' => 10, 'reason' => 'PWV используется как vascular stiffness marker.'],
                'longevity' => ['status' => 'applicable', 'primary' => false, 'priority' => 20, 'reason' => 'PWV может использоваться в vascular aging/longevity context.'],
            ],

            'coronary-calcium-score' => [
                'general-adult' => ['status' => 'needs_review', 'primary' => false, 'priority' => 95, 'reason' => 'CAC score требует imaging-specific cardiovascular interpretation.'],
                'cardiovascular-risk' => ['status' => 'applicable', 'primary' => true, 'priority' => 5, 'reason' => 'CAC score является одним из strongest cardiovascular risk markers.'],
                'senior' => ['status' => 'applicable', 'primary' => false, 'priority' => 15, 'reason' => 'CAC score особенно важен в age-related cardiovascular risk context.'],
            ],

            'waist-height-ratio' => [
                'general-adult' => ['status' => 'applicable', 'primary' => true, 'priority' => 15, 'reason' => 'WHtR используется как simple metabolic-risk anthropometric marker.'],
                'insulin-resistance' => ['status' => 'applicable', 'primary' => true, 'priority' => 5, 'reason' => 'WHtR тесно связан с visceral adiposity и insulin resistance.'],
                'cardiovascular-risk' => ['status' => 'applicable', 'primary' => false, 'priority' => 20, 'reason' => 'WHtR связан с cardiometabolic risk.'],
            ],

            'visceral-fat-estimate' => [
                'general-adult' => ['status' => 'needs_review', 'primary' => false, 'priority' => 85, 'reason' => 'Visceral fat estimate требует body-composition methodology.'],
                'insulin-resistance' => ['status' => 'applicable', 'primary' => true, 'priority' => 5, 'reason' => 'Visceral adiposity является ключевым metabolic-risk factor.'],
                'cardiovascular-risk' => ['status' => 'applicable', 'primary' => false, 'priority' => 15, 'reason' => 'Visceral fat тесно связан с cardiovascular risk.'],
            ],

            'cortisol-am' => [
                'general-adult' => ['status' => 'applicable', 'primary' => false, 'priority' => 40, 'reason' => 'Morning cortisol используется как circadian stress marker.'],
                'athlete' => ['status' => 'applicable', 'primary' => false, 'priority' => 25, 'reason' => 'Morning cortisol может быть полезен в recovery/training stress context.'],
                'longevity' => ['status' => 'needs_review', 'primary' => false, 'priority' => 85, 'reason' => 'Longevity interpretation для cortisol-AM требует validated methodology.'],
            ],

            'cortisol-pm' => [
                'general-adult' => ['status' => 'needs_review', 'primary' => false, 'priority' => 85, 'reason' => 'Evening cortisol требует circadian-specific interpretation.'],
                'athlete' => ['status' => 'applicable', 'primary' => false, 'priority' => 30, 'reason' => 'Evening cortisol может отражать recovery/stress imbalance.'],
                'longevity' => ['status' => 'needs_review', 'primary' => false, 'priority' => 90, 'reason' => 'Circadian cortisol interpretation требует validated longevity methodology.'],
            ],

            'melatonin' => [
                'general-adult' => ['status' => 'needs_review', 'primary' => false, 'priority' => 95, 'reason' => 'Melatonin требует sleep/circadian-specific interpretation strategy.'],
                'longevity' => ['status' => 'applicable', 'primary' => true, 'priority' => 15, 'reason' => 'Melatonin может быть полезен в circadian/longevity context.'],
            ],

            'heart-rate-variability' => [
                'general-adult' => ['status' => 'needs_review', 'primary' => false, 'priority' => 90, 'reason' => 'HRV требует wearable/recovery-specific interpretation methodology.'],
                'athlete' => ['status' => 'applicable', 'primary' => true, 'priority' => 5, 'reason' => 'HRV широко используется в athlete recovery/load management context.'],
                'longevity' => ['status' => 'applicable', 'primary' => false, 'priority' => 20, 'reason' => 'HRV может использоваться как autonomic/longevity marker.'],
                'cardiovascular-risk' => ['status' => 'applicable', 'primary' => false, 'priority' => 30, 'reason' => 'HRV связан с autonomic cardiovascular regulation.'],
            ],

            'resting-heart-rate' => [
                'general-adult' => ['status' => 'applicable', 'primary' => true, 'priority' => 10, 'reason' => 'Resting heart rate является базовым cardiovascular/autonomic marker.'],
                'athlete' => ['status' => 'applicable', 'primary' => false, 'priority' => 20, 'reason' => 'RHR важен в athlete recovery/performance context.'],
                'cardiovascular-risk' => ['status' => 'applicable', 'primary' => true, 'priority' => 5, 'reason' => 'Elevated resting HR связан с cardiovascular risk.'],
                'longevity' => ['status' => 'applicable', 'primary' => false, 'priority' => 25, 'reason' => 'Resting HR может использоваться в longevity/autonomic context.'],
            ],

            'sleep-duration' => [
                'general-adult' => ['status' => 'applicable', 'primary' => true, 'priority' => 20, 'reason' => 'Sleep duration является базовым recovery/lifestyle marker.'],
                'athlete' => ['status' => 'applicable', 'primary' => false, 'priority' => 15, 'reason' => 'Sleep duration критически важен для athlete recovery.'],
                'longevity' => ['status' => 'applicable', 'primary' => false, 'priority' => 25, 'reason' => 'Sleep duration важен в preventive/longevity context.'],
            ],

            'sleep-efficiency' => [
                'general-adult' => ['status' => 'needs_review', 'primary' => false, 'priority' => 85, 'reason' => 'Sleep efficiency требует wearable/sleep-specific methodology.'],
                'longevity' => ['status' => 'applicable', 'primary' => false, 'priority' => 20, 'reason' => 'Sleep efficiency может быть полезен в recovery/longevity context.'],
                'athlete' => ['status' => 'applicable', 'primary' => true, 'priority' => 10, 'reason' => 'Sleep efficiency важен для athlete recovery quality.'],
            ],

            'vo2-max-estimate' => [
                'general-adult' => ['status' => 'needs_review', 'primary' => false, 'priority' => 90, 'reason' => 'VO2 max estimate требует fitness/performance-specific interpretation.'],
                'athlete' => ['status' => 'applicable', 'primary' => true, 'priority' => 5, 'reason' => 'VO2 max является ключевым aerobic fitness marker.'],
                'longevity' => ['status' => 'applicable', 'primary' => false, 'priority' => 15, 'reason' => 'VO2 max тесно связан с healthspan/longevity context.'],
                'cardiovascular-risk' => ['status' => 'applicable', 'primary' => false, 'priority' => 25, 'reason' => 'Cardiorespiratory fitness связан с cardiovascular outcomes.'],
            ],

            'body-fat-percentage' => [
                'general-adult' => ['status' => 'applicable', 'primary' => true, 'priority' => 15, 'reason' => 'Body fat percentage используется как базовый body-composition marker.'],
                'insulin-resistance' => ['status' => 'applicable', 'primary' => true, 'priority' => 10, 'reason' => 'Body fat percentage связан с metabolic risk context.'],
                'athlete' => ['status' => 'applicable', 'primary' => false, 'priority' => 20, 'reason' => 'Body composition важен в athlete performance/recovery context.'],
                'longevity' => ['status' => 'applicable', 'primary' => false, 'priority' => 25, 'reason' => 'Body composition может использоваться в longevity context.'],
            ],

            'lean-body-mass' => [
                'general-adult' => ['status' => 'applicable', 'primary' => false, 'priority' => 30, 'reason' => 'Lean body mass используется как body-composition marker.'],
                'athlete' => ['status' => 'applicable', 'primary' => true, 'priority' => 10, 'reason' => 'Lean mass важен в athlete performance context.'],
                'senior' => ['status' => 'applicable', 'primary' => false, 'priority' => 20, 'reason' => 'Lean body mass важен для sarcopenia/aging context.'],
                'longevity' => ['status' => 'applicable', 'primary' => false, 'priority' => 30, 'reason' => 'Lean mass связан с healthy aging context.'],
            ],

            'grip-strength' => [
                'general-adult' => ['status' => 'applicable', 'primary' => false, 'priority' => 30, 'reason' => 'Grip strength используется как functional performance marker.'],
                'senior' => ['status' => 'applicable', 'primary' => true, 'priority' => 5, 'reason' => 'Grip strength является одним из ключевых frailty/sarcopenia markers.'],
                'longevity' => ['status' => 'applicable', 'primary' => false, 'priority' => 15, 'reason' => 'Grip strength связан с healthy aging/longevity context.'],
            ],

            'gait-speed' => [
                'general-adult' => ['status' => 'needs_review', 'primary' => false, 'priority' => 80, 'reason' => 'Gait speed требует functional-aging interpretation strategy.'],
                'senior' => ['status' => 'applicable', 'primary' => true, 'priority' => 5, 'reason' => 'Gait speed является одним из strongest frailty markers.'],
                'longevity' => ['status' => 'applicable', 'primary' => false, 'priority' => 15, 'reason' => 'Gait speed важен для healthy aging assessment.'],
            ],

            'frailty-index' => [
                'general-adult' => ['status' => 'needs_review', 'primary' => false, 'priority' => 95, 'reason' => 'Frailty index требует dedicated geriatric scoring methodology.'],
                'senior' => ['status' => 'applicable', 'primary' => true, 'priority' => 5, 'reason' => 'Frailty index критически важен для geriatric risk assessment.'],
                'longevity' => ['status' => 'applicable', 'primary' => false, 'priority' => 15, 'reason' => 'Frailty burden связан с healthy aging context.'],
            ],

            'sarcopenia-risk-score' => [
                'general-adult' => ['status' => 'needs_review', 'primary' => false, 'priority' => 90, 'reason' => 'Sarcopenia risk score требует muscle-aging methodology.'],
                'senior' => ['status' => 'applicable', 'primary' => true, 'priority' => 5, 'reason' => 'Sarcopenia risk важен для aging/frailty context.'],
                'longevity' => ['status' => 'applicable', 'primary' => false, 'priority' => 15, 'reason' => 'Muscle preservation связан с healthspan/longevity.'],
            ],

            'biological-age-estimate' => [
                'general-adult' => ['status' => 'needs_review', 'primary' => false, 'priority' => 98, 'reason' => 'Biological age требует composite multi-marker methodology.'],
                'longevity' => ['status' => 'applicable', 'primary' => true, 'priority' => 5, 'reason' => 'Biological age estimate является core longevity-context marker.'],
            ],

            'epigenetic-age-estimate' => [
                'general-adult' => ['status' => 'needs_review', 'primary' => false, 'priority' => 99, 'reason' => 'Epigenetic clocks требуют highly specialized methodology.'],
                'longevity' => ['status' => 'applicable', 'primary' => true, 'priority' => 5, 'reason' => 'Epigenetic age является advanced longevity marker.'],
            ],

            'recovery-score' => [
                'general-adult' => ['status' => 'needs_review', 'primary' => false, 'priority' => 85, 'reason' => 'Recovery score требует wearable/recovery-specific interpretation.'],
                'athlete' => ['status' => 'applicable', 'primary' => true, 'priority' => 5, 'reason' => 'Recovery score важен в training/recovery context.'],
                'longevity' => ['status' => 'applicable', 'primary' => false, 'priority' => 20, 'reason' => 'Recovery capacity может использоваться в resilience/longevity context.'],
            ],

            'stress-load-score' => [
                'general-adult' => ['status' => 'needs_review', 'primary' => false, 'priority' => 90, 'reason' => 'Stress-load score требует composite stress methodology.'],
                'athlete' => ['status' => 'applicable', 'primary' => false, 'priority' => 20, 'reason' => 'Stress load важен в training adaptation context.'],
                'longevity' => ['status' => 'applicable', 'primary' => true, 'priority' => 10, 'reason' => 'Chronic stress burden связан с longevity/resilience context.'],
            ],

            'metabolic-flexibility-score' => [
                'general-adult' => ['status' => 'needs_review', 'primary' => false, 'priority' => 92, 'reason' => 'Metabolic flexibility требует advanced metabolic methodology.'],
                'insulin-resistance' => ['status' => 'applicable', 'primary' => true, 'priority' => 10, 'reason' => 'Metabolic flexibility тесно связана с insulin resistance context.'],
                'longevity' => ['status' => 'applicable', 'primary' => false, 'priority' => 20, 'reason' => 'Metabolic adaptability важна для healthy aging context.'],
            ],

            'resilience-score' => [
                'general-adult' => ['status' => 'needs_review', 'primary' => false, 'priority' => 95, 'reason' => 'Resilience score требует composite physiologic methodology.'],
                'longevity' => ['status' => 'applicable', 'primary' => true, 'priority' => 5, 'reason' => 'Physiologic resilience является ключевым longevity concept.'],
                'athlete' => ['status' => 'applicable', 'primary' => false, 'priority' => 15, 'reason' => 'Recovery resilience важна в athlete adaptation context.'],
            ],

            'mercury' => [
                'general-adult' => ['status' => 'needs_review', 'primary' => false, 'priority' => 92, 'reason' => 'Mercury interpretation требует exposure/toxicology-specific methodology.'],
                'longevity' => ['status' => 'applicable', 'primary' => false, 'priority' => 25, 'reason' => 'Mercury burden может быть важен в environmental longevity context.'],
                'neurologic-risk' => ['status' => 'applicable', 'primary' => true, 'priority' => 10, 'reason' => 'Mercury exposure важен в neurologic/toxic exposure context.'],
            ],

            'lead' => [
                'general-adult' => ['status' => 'needs_review', 'primary' => false, 'priority' => 92, 'reason' => 'Lead требует toxicology-specific interpretation strategy.'],
                'neurologic-risk' => ['status' => 'applicable', 'primary' => true, 'priority' => 10, 'reason' => 'Lead exposure связан с neurologic and systemic toxicity.'],
                'cardiovascular-risk' => ['status' => 'applicable', 'primary' => false, 'priority' => 25, 'reason' => 'Lead burden может быть связан с vascular dysfunction context.'],
            ],

            'arsenic' => [
                'general-adult' => ['status' => 'needs_review', 'primary' => false, 'priority' => 94, 'reason' => 'Arsenic требует environmental toxicology methodology.'],
                'longevity' => ['status' => 'applicable', 'primary' => false, 'priority' => 30, 'reason' => 'Environmental toxin burden может быть важен для healthy aging context.'],
            ],

            'cadmium' => [
                'general-adult' => ['status' => 'needs_review', 'primary' => false, 'priority' => 94, 'reason' => 'Cadmium interpretation требует toxic exposure methodology.'],
                'cardiovascular-risk' => ['status' => 'applicable', 'primary' => false, 'priority' => 30, 'reason' => 'Cadmium exposure может быть связан с vascular dysfunction context.'],
                'kidney-risk' => ['status' => 'applicable', 'primary' => true, 'priority' => 10, 'reason' => 'Cadmium exposure связан с kidney toxicity risk.'],
            ],

            'bpa' => [
                'general-adult' => ['status' => 'needs_review', 'primary' => false, 'priority' => 96, 'reason' => 'BPA требует endocrine-disruption interpretation methodology.'],
                'insulin-resistance' => ['status' => 'needs_review', 'primary' => false, 'priority' => 85, 'reason' => 'BPA/metabolic interaction требует stronger evidence framework.'],
                'longevity' => ['status' => 'needs_review', 'primary' => false, 'priority' => 90, 'reason' => 'Environmental endocrine disruptor logic требует validated methodology.'],
            ],

            'oxidized-ldl' => [
                'general-adult' => ['status' => 'needs_review', 'primary' => false, 'priority' => 88, 'reason' => 'Oxidized LDL требует advanced oxidative-stress interpretation.'],
                'cardiovascular-risk' => ['status' => 'applicable', 'primary' => true, 'priority' => 10, 'reason' => 'Oxidized LDL важен в vascular inflammation/atherogenic context.'],
                'insulin-resistance' => ['status' => 'applicable', 'primary' => false, 'priority' => 25, 'reason' => 'Oxidative lipid stress связан с metabolic dysfunction.'],
            ],

            'glutathione' => [
                'general-adult' => ['status' => 'needs_review', 'primary' => false, 'priority' => 90, 'reason' => 'Glutathione interpretation требует oxidative-stress methodology.'],
                'longevity' => ['status' => 'applicable', 'primary' => true, 'priority' => 15, 'reason' => 'Glutathione может использоваться как oxidative resilience marker.'],
                'chronic-inflammation-risk' => ['status' => 'applicable', 'primary' => false, 'priority' => 30, 'reason' => 'Oxidative stress тесно связан с chronic inflammation context.'],
            ],

            'malondialdehyde' => [
                'general-adult' => ['status' => 'needs_review', 'primary' => false, 'priority' => 94, 'reason' => 'MDA требует oxidative stress-specific methodology.'],
                'cardiovascular-risk' => ['status' => 'applicable', 'primary' => false, 'priority' => 25, 'reason' => 'Lipid peroxidation важна в vascular oxidative context.'],
                'longevity' => ['status' => 'applicable', 'primary' => true, 'priority' => 15, 'reason' => 'Oxidative burden связан с aging/longevity context.'],
            ],

            'advanced-glycation-end-products' => [
                'general-adult' => ['status' => 'needs_review', 'primary' => false, 'priority' => 96, 'reason' => 'AGEs требуют advanced glycation methodology.'],
                'insulin-resistance' => ['status' => 'applicable', 'primary' => false, 'priority' => 25, 'reason' => 'AGE burden связан с metabolic dysfunction.'],
                'cardiovascular-risk' => ['status' => 'applicable', 'primary' => false, 'priority' => 30, 'reason' => 'AGE accumulation связан с vascular aging.'],
                'longevity' => ['status' => 'applicable', 'primary' => true, 'priority' => 10, 'reason' => 'AGE burden является важным aging-related concept.'],
            ],

            'mitochondrial-function-score' => [
                'general-adult' => ['status' => 'needs_review', 'primary' => false, 'priority' => 98, 'reason' => 'Mitochondrial function score требует composite systems-biology methodology.'],
                'longevity' => ['status' => 'applicable', 'primary' => true, 'priority' => 5, 'reason' => 'Mitochondrial health является core longevity concept.'],
                'athlete' => ['status' => 'applicable', 'primary' => false, 'priority' => 20, 'reason' => 'Mitochondrial efficiency важна в endurance/recovery context.'],
            ],

            'bdnf' => [
                'general-adult' => ['status' => 'needs_review', 'primary' => false, 'priority' => 96, 'reason' => 'BDNF требует neurobiology-specific interpretation methodology.'],
                'longevity' => ['status' => 'applicable', 'primary' => true, 'priority' => 15, 'reason' => 'BDNF связан с neuroplasticity and healthy aging context.'],
                'athlete' => ['status' => 'applicable', 'primary' => false, 'priority' => 30, 'reason' => 'Exercise adaptation и recovery могут быть связаны с BDNF context.'],
            ],

            'homovanillic-acid' => [
                'general-adult' => ['status' => 'needs_review', 'primary' => false, 'priority' => 98, 'reason' => 'HVA требует neurotransmitter-metabolism methodology.'],
                'neurologic-risk' => ['status' => 'applicable', 'primary' => true, 'priority' => 10, 'reason' => 'HVA может использоваться в dopamine-metabolism context.'],
            ],

            'serotonin' => [
                'general-adult' => ['status' => 'needs_review', 'primary' => false, 'priority' => 95, 'reason' => 'Peripheral serotonin требует careful neuro-metabolic interpretation.'],
                'neurologic-risk' => ['status' => 'applicable', 'primary' => false, 'priority' => 25, 'reason' => 'Serotonin может использоваться в neuro-regulation context.'],
                'longevity' => ['status' => 'needs_review', 'primary' => false, 'priority' => 90, 'reason' => 'Longevity interpretation для serotonin требует stronger evidence framework.'],
            ],

            'neurofilament-light-chain' => [
                'general-adult' => ['status' => 'needs_review', 'primary' => false, 'priority' => 99, 'reason' => 'NfL требует neurodegeneration-specific interpretation strategy.'],
                'neurologic-risk' => ['status' => 'applicable', 'primary' => true, 'priority' => 5, 'reason' => 'Neurofilament light является marker neuronal injury/neurodegeneration.'],
                'senior' => ['status' => 'applicable', 'primary' => false, 'priority' => 15, 'reason' => 'NfL может быть важен в age-related neurodegenerative context.'],
            ],

            'amyloid-beta-ratio' => [
                'general-adult' => ['status' => 'needs_review', 'primary' => false, 'priority' => 99, 'reason' => 'Amyloid-beta ratio требует Alzheimer-specific methodology.'],
                'neurologic-risk' => ['status' => 'applicable', 'primary' => true, 'priority' => 5, 'reason' => 'Amyloid-beta ratio используется в neurodegeneration/cognitive decline context.'],
                'senior' => ['status' => 'applicable', 'primary' => false, 'priority' => 15, 'reason' => 'Amyloid biomarkers могут быть важны в aging cognition context.'],
            ],

            'tau-protein' => [
                'general-adult' => ['status' => 'needs_review', 'primary' => false, 'priority' => 99, 'reason' => 'Tau protein требует neurodegeneration-specific methodology.'],
                'neurologic-risk' => ['status' => 'applicable', 'primary' => true, 'priority' => 5, 'reason' => 'Tau protein используется в neurodegenerative disease context.'],
            ],

            'hs-il6' => [
                'general-adult' => ['status' => 'needs_review', 'primary' => false, 'priority' => 92, 'reason' => 'hs-IL6 требует inflammatory-aging interpretation strategy.'],
                'chronic-inflammation-risk' => ['status' => 'applicable', 'primary' => true, 'priority' => 10, 'reason' => 'hs-IL6 является ключевым chronic inflammation marker.'],
                'longevity' => ['status' => 'applicable', 'primary' => false, 'priority' => 20, 'reason' => 'Inflammaging context тесно связан с IL-6 signaling.'],
            ],

            'brain-age-estimate' => [
                'general-adult' => ['status' => 'needs_review', 'primary' => false, 'priority' => 99, 'reason' => 'Brain age estimate требует advanced neuro-aging composite methodology.'],
                'longevity' => ['status' => 'applicable', 'primary' => true, 'priority' => 5, 'reason' => 'Brain aging является core longevity domain.'],
                'neurologic-risk' => ['status' => 'applicable', 'primary' => false, 'priority' => 15, 'reason' => 'Brain age может использоваться в neurodegeneration-risk context.'],
            ],

            'cognitive-performance-score' => [
                'general-adult' => ['status' => 'needs_review', 'primary' => false, 'priority' => 95, 'reason' => 'Cognitive performance score требует neurocognitive methodology.'],
                'longevity' => ['status' => 'applicable', 'primary' => false, 'priority' => 20, 'reason' => 'Cognitive preservation важна для healthy aging context.'],
                'neurologic-risk' => ['status' => 'applicable', 'primary' => true, 'priority' => 10, 'reason' => 'Cognitive performance важен в neurologic-risk context.'],
            ],

            'neuroinflammation-score' => [
                'general-adult' => ['status' => 'needs_review', 'primary' => false, 'priority' => 98, 'reason' => 'Neuroinflammation score требует composite neuroimmune methodology.'],
                'neurologic-risk' => ['status' => 'applicable', 'primary' => true, 'priority' => 10, 'reason' => 'Neuroinflammation важна в neurodegeneration-risk context.'],
                'chronic-inflammation-risk' => ['status' => 'applicable', 'primary' => false, 'priority' => 20, 'reason' => 'Systemic inflammation может пересекаться с neuroinflammatory context.'],
            ],

            'lactate-threshold-estimate' => [
                'general-adult' => ['status' => 'needs_review', 'primary' => false, 'priority' => 94, 'reason' => 'Lactate threshold требует exercise-physiology methodology.'],
                'athlete' => ['status' => 'applicable', 'primary' => true, 'priority' => 5, 'reason' => 'Lactate threshold является ключевым endurance/performance marker.'],
                'longevity' => ['status' => 'applicable', 'primary' => false, 'priority' => 20, 'reason' => 'Aerobic adaptive capacity связана с healthy aging context.'],
            ],

            'blood-lactate' => [
                'general-adult' => ['status' => 'needs_review', 'primary' => false, 'priority' => 92, 'reason' => 'Blood lactate требует exercise/metabolic context methodology.'],
                'athlete' => ['status' => 'applicable', 'primary' => true, 'priority' => 10, 'reason' => 'Blood lactate важен для training adaptation context.'],
                'mitochondrial-risk' => ['status' => 'applicable', 'primary' => false, 'priority' => 25, 'reason' => 'Lactate metabolism может быть связан с mitochondrial dysfunction context.'],
            ],

            'metabolic-age-estimate' => [
                'general-adult' => ['status' => 'needs_review', 'primary' => false, 'priority' => 97, 'reason' => 'Metabolic age estimate требует composite methodology.'],
                'longevity' => ['status' => 'applicable', 'primary' => true, 'priority' => 5, 'reason' => 'Metabolic age используется как preventive/longevity concept.'],
                'insulin-resistance' => ['status' => 'applicable', 'primary' => false, 'priority' => 15, 'reason' => 'Metabolic dysfunction тесно связан с metabolic-age burden.'],
            ],

            'vascular-age-estimate' => [
                'general-adult' => ['status' => 'needs_review', 'primary' => false, 'priority' => 97, 'reason' => 'Vascular age estimate требует vascular composite methodology.'],
                'cardiovascular-risk' => ['status' => 'applicable', 'primary' => true, 'priority' => 5, 'reason' => 'Vascular age важен для cardiovascular-risk assessment.'],
                'longevity' => ['status' => 'applicable', 'primary' => false, 'priority' => 15, 'reason' => 'Vascular aging является core longevity domain.'],
            ],

            'oxygen-saturation-resting' => [
                'general-adult' => ['status' => 'applicable', 'primary' => true, 'priority' => 20, 'reason' => 'Resting oxygen saturation является базовым physiologic marker.'],
                'athlete' => ['status' => 'applicable', 'primary' => false, 'priority' => 25, 'reason' => 'Oxygen delivery важна для endurance/performance context.'],
                'senior' => ['status' => 'applicable', 'primary' => false, 'priority' => 15, 'reason' => 'У пожилых oxygenation reserve становится более значимой.'],
            ],

            'respiratory-rate-resting' => [
                'general-adult' => ['status' => 'applicable', 'primary' => true, 'priority' => 20, 'reason' => 'Resting respiratory rate является базовым physiologic stability marker.'],
                'cardiovascular-risk' => ['status' => 'applicable', 'primary' => false, 'priority' => 30, 'reason' => 'Respiratory burden может пересекаться с cardiovascular dysfunction context.'],
                'longevity' => ['status' => 'applicable', 'primary' => false, 'priority' => 35, 'reason' => 'Respiratory reserve может использоваться в healthy aging context.'],
            ],

            'heat-recovery-score' => [
                'general-adult' => ['status' => 'needs_review', 'primary' => false, 'priority' => 96, 'reason' => 'Heat recovery требует environmental/exercise adaptation methodology.'],
                'athlete' => ['status' => 'applicable', 'primary' => true, 'priority' => 15, 'reason' => 'Heat adaptation важна в athlete stress/recovery context.'],
            ],

            'cold-exposure-adaptation-score' => [
                'general-adult' => ['status' => 'needs_review', 'primary' => false, 'priority' => 97, 'reason' => 'Cold adaptation требует hormetic-stress methodology.'],
                'longevity' => ['status' => 'applicable', 'primary' => false, 'priority' => 25, 'reason' => 'Hormetic stress adaptation обсуждается в longevity context.'],
                'athlete' => ['status' => 'applicable', 'primary' => true, 'priority' => 15, 'reason' => 'Cold adaptation может использоваться в recovery/adaptation context.'],
            ],

            'circadian-alignment-score' => [
                'general-adult' => ['status' => 'needs_review', 'primary' => false, 'priority' => 95, 'reason' => 'Circadian alignment требует sleep/circadian methodology.'],
                'longevity' => ['status' => 'applicable', 'primary' => true, 'priority' => 10, 'reason' => 'Circadian stability важна для healthy aging context.'],
                'athlete' => ['status' => 'applicable', 'primary' => false, 'priority' => 20, 'reason' => 'Circadian recovery alignment важна для athlete performance.'],
            ],

            'autonomic-balance-score' => [
                'general-adult' => ['status' => 'needs_review', 'primary' => false, 'priority' => 94, 'reason' => 'Autonomic balance требует HRV/autonomic methodology.'],
                'athlete' => ['status' => 'applicable', 'primary' => false, 'priority' => 20, 'reason' => 'Autonomic balance важен в recovery/load adaptation context.'],
                'longevity' => ['status' => 'applicable', 'primary' => true, 'priority' => 10, 'reason' => 'Autonomic resilience важна для healthy aging context.'],
                'cardiovascular-risk' => ['status' => 'applicable', 'primary' => false, 'priority' => 25, 'reason' => 'Autonomic dysfunction связан с cardiovascular risk context.'],
            ],

            'apnea-hypopnea-index' => [
                'general-adult' => ['status' => 'needs_review', 'primary' => false, 'priority' => 96, 'reason' => 'AHI требует sleep-medicine specific interpretation.'],
                'cardiovascular-risk' => ['status' => 'applicable', 'primary' => true, 'priority' => 10, 'reason' => 'Sleep apnea burden тесно связан с cardiovascular risk.'],
                'longevity' => ['status' => 'applicable', 'primary' => false, 'priority' => 20, 'reason' => 'Sleep-disordered breathing влияет на healthy aging context.'],
            ],

            'oxygen-desaturation-index' => [
                'general-adult' => ['status' => 'needs_review', 'primary' => false, 'priority' => 95, 'reason' => 'ODI требует sleep-breathing methodology.'],
                'cardiovascular-risk' => ['status' => 'applicable', 'primary' => true, 'priority' => 15, 'reason' => 'Nocturnal desaturation связана с cardiovascular stress burden.'],
                'longevity' => ['status' => 'applicable', 'primary' => false, 'priority' => 25, 'reason' => 'Sleep oxygenation влияет на recovery and aging context.'],
            ],

            'overnight-heart-rate' => [
                'general-adult' => ['status' => 'applicable', 'primary' => false, 'priority' => 30, 'reason' => 'Night HR используется как recovery/autonomic marker.'],
                'athlete' => ['status' => 'applicable', 'primary' => true, 'priority' => 10, 'reason' => 'Overnight HR важен для athlete recovery assessment.'],
                'cardiovascular-risk' => ['status' => 'applicable', 'primary' => false, 'priority' => 20, 'reason' => 'Elevated night HR может быть связан с autonomic/cardiovascular burden.'],
                'longevity' => ['status' => 'applicable', 'primary' => false, 'priority' => 25, 'reason' => 'Night recovery physiology важна для healthy aging context.'],
            ],

            'overnight-hrv' => [
                'general-adult' => ['status' => 'needs_review', 'primary' => false, 'priority' => 90, 'reason' => 'Night HRV требует wearable/autonomic methodology.'],
                'athlete' => ['status' => 'applicable', 'primary' => true, 'priority' => 5, 'reason' => 'Overnight HRV является ключевым recovery marker.'],
                'longevity' => ['status' => 'applicable', 'primary' => false, 'priority' => 15, 'reason' => 'Autonomic recovery capacity важна для longevity context.'],
            ],

            'recovery-heart-rate-drop' => [
                'general-adult' => ['status' => 'needs_review', 'primary' => false, 'priority' => 92, 'reason' => 'Recovery HR drop требует exercise/autonomic methodology.'],
                'athlete' => ['status' => 'applicable', 'primary' => true, 'priority' => 5, 'reason' => 'Heart-rate recovery является важным fitness/recovery marker.'],
                'cardiovascular-risk' => ['status' => 'applicable', 'primary' => false, 'priority' => 15, 'reason' => 'Delayed HR recovery связан с cardiovascular/autonomic dysfunction.'],
                'longevity' => ['status' => 'applicable', 'primary' => false, 'priority' => 20, 'reason' => 'Recovery reserve важен для healthy aging context.'],
            ],

            'breathing-variability-score' => [
                'general-adult' => ['status' => 'needs_review', 'primary' => false, 'priority' => 96, 'reason' => 'Breathing variability требует respiratory/autonomic methodology.'],
                'longevity' => ['status' => 'applicable', 'primary' => false, 'priority' => 25, 'reason' => 'Respiratory adaptability может использоваться в resilience/longevity context.'],
                'athlete' => ['status' => 'applicable', 'primary' => true, 'priority' => 15, 'reason' => 'Respiratory regulation важна в performance/recovery context.'],
            ],

            'sleep-fragmentation-index' => [
                'general-adult' => ['status' => 'needs_review', 'primary' => false, 'priority' => 94, 'reason' => 'Sleep fragmentation требует sleep-analysis methodology.'],
                'longevity' => ['status' => 'applicable', 'primary' => true, 'priority' => 15, 'reason' => 'Sleep continuity важна для healthy aging context.'],
                'athlete' => ['status' => 'applicable', 'primary' => false, 'priority' => 20, 'reason' => 'Sleep fragmentation влияет на recovery quality.'],
            ],

            'deep-sleep-ratio' => [
                'general-adult' => ['status' => 'needs_review', 'primary' => false, 'priority' => 93, 'reason' => 'Deep sleep ratio требует wearable/sleep-stage methodology.'],
                'longevity' => ['status' => 'applicable', 'primary' => true, 'priority' => 15, 'reason' => 'Deep sleep quality важна для restorative aging context.'],
                'athlete' => ['status' => 'applicable', 'primary' => false, 'priority' => 20, 'reason' => 'Deep sleep важен для athlete recovery.'],
            ],

            'rem-sleep-ratio' => [
                'general-adult' => ['status' => 'needs_review', 'primary' => false, 'priority' => 93, 'reason' => 'REM sleep ratio требует sleep-stage methodology.'],
                'neurologic-risk' => ['status' => 'applicable', 'primary' => true, 'priority' => 20, 'reason' => 'REM architecture может быть связана с neurologic/cognitive context.'],
                'longevity' => ['status' => 'applicable', 'primary' => false, 'priority' => 25, 'reason' => 'REM quality может использоваться в cognitive aging context.'],
            ],

            'sleep-debt-estimate' => [
                'general-adult' => ['status' => 'applicable', 'primary' => false, 'priority' => 35, 'reason' => 'Sleep debt используется как recovery-burden marker.'],
                'athlete' => ['status' => 'applicable', 'primary' => true, 'priority' => 10, 'reason' => 'Sleep debt критически влияет на athlete recovery capacity.'],
                'longevity' => ['status' => 'applicable', 'primary' => false, 'priority' => 20, 'reason' => 'Chronic sleep debt связан с healthy aging burden.'],
                'cardiovascular-risk' => ['status' => 'applicable', 'primary' => false, 'priority' => 30, 'reason' => 'Sleep deprivation связан с cardiovascular stress context.'],
            ],

            'time-in-range' => [
                'general-adult' => ['status' => 'needs_review', 'primary' => false, 'priority' => 92, 'reason' => 'Time-in-range требует CGM-specific metabolic methodology.'],
                'insulin-resistance' => ['status' => 'applicable', 'primary' => true, 'priority' => 5, 'reason' => 'Time-in-range является ключевым dynamic glucose marker.'],
                'cardiovascular-risk' => ['status' => 'applicable', 'primary' => false, 'priority' => 15, 'reason' => 'Glucose stability связана с cardiometabolic burden.'],
                'longevity' => ['status' => 'applicable', 'primary' => false, 'priority' => 20, 'reason' => 'Metabolic stability важна для healthy aging context.'],
            ],

            'glucose-variability-score' => [
                'general-adult' => ['status' => 'needs_review', 'primary' => false, 'priority' => 94, 'reason' => 'Glucose variability требует continuous metabolic-data methodology.'],
                'insulin-resistance' => ['status' => 'applicable', 'primary' => true, 'priority' => 5, 'reason' => 'Glucose variability является ключевым marker metabolic instability.'],
                'cardiovascular-risk' => ['status' => 'applicable', 'primary' => false, 'priority' => 20, 'reason' => 'High glycemic variability может быть связана с vascular stress burden.'],
            ],

            'post-meal-glucose-response' => [
                'general-adult' => ['status' => 'needs_review', 'primary' => false, 'priority' => 93, 'reason' => 'Post-meal glucose response требует meal-context metabolic methodology.'],
                'insulin-resistance' => ['status' => 'applicable', 'primary' => true, 'priority' => 5, 'reason' => 'Postprandial response важен для early metabolic dysfunction detection.'],
                'longevity' => ['status' => 'applicable', 'primary' => false, 'priority' => 20, 'reason' => 'Post-meal metabolic resilience важна для healthy aging context.'],
            ],

            'fasting-ketones' => [
                'general-adult' => ['status' => 'needs_review', 'primary' => false, 'priority' => 90, 'reason' => 'Fasting ketones требуют metabolic-state interpretation strategy.'],
                'insulin-resistance' => ['status' => 'applicable', 'primary' => false, 'priority' => 20, 'reason' => 'Ketone production может отражать metabolic flexibility context.'],
                'longevity' => ['status' => 'applicable', 'primary' => true, 'priority' => 15, 'reason' => 'Metabolic flexibility и ketone adaptation обсуждаются в longevity context.'],
            ],

            'beta-hydroxybutyrate' => [
                'general-adult' => ['status' => 'needs_review', 'primary' => false, 'priority' => 92, 'reason' => 'BHB требует ketosis/metabolic-state methodology.'],
                'longevity' => ['status' => 'applicable', 'primary' => true, 'priority' => 10, 'reason' => 'Ketone metabolism часто используется в longevity/metabolic resilience context.'],
                'insulin-resistance' => ['status' => 'applicable', 'primary' => false, 'priority' => 20, 'reason' => 'Ketone regulation связана с metabolic flexibility context.'],
            ],

            'insulin-response-score' => [
                'general-adult' => ['status' => 'needs_review', 'primary' => false, 'priority' => 95, 'reason' => 'Insulin response score требует dynamic metabolic testing methodology.'],
                'insulin-resistance' => ['status' => 'applicable', 'primary' => true, 'priority' => 5, 'reason' => 'Dynamic insulin response является core insulin-resistance concept.'],
                'cardiovascular-risk' => ['status' => 'applicable', 'primary' => false, 'priority' => 20, 'reason' => 'Hyperinsulinemic burden связан с cardiovascular risk.'],
            ],

            'metabolic-recovery-rate' => [
                'general-adult' => ['status' => 'needs_review', 'primary' => false, 'priority' => 96, 'reason' => 'Metabolic recovery rate требует longitudinal physiology methodology.'],
                'athlete' => ['status' => 'applicable', 'primary' => false, 'priority' => 20, 'reason' => 'Metabolic recovery важен в adaptation/performance context.'],
                'insulin-resistance' => ['status' => 'applicable', 'primary' => true, 'priority' => 10, 'reason' => 'Slow metabolic recovery связан с impaired metabolic flexibility.'],
                'longevity' => ['status' => 'applicable', 'primary' => false, 'priority' => 25, 'reason' => 'Adaptive metabolic recovery важен для healthy aging.'],
            ],

            'metabolic-stability-index' => [
                'general-adult' => ['status' => 'needs_review', 'primary' => false, 'priority' => 97, 'reason' => 'Metabolic stability index требует composite metabolic methodology.'],
                'insulin-resistance' => ['status' => 'applicable', 'primary' => true, 'priority' => 5, 'reason' => 'Metabolic stability является core metabolic-health concept.'],
                'longevity' => ['status' => 'applicable', 'primary' => false, 'priority' => 15, 'reason' => 'Metabolic resilience важна для healthy aging context.'],
            ],

            'glycation-burden-score' => [
                'general-adult' => ['status' => 'needs_review', 'primary' => false, 'priority' => 95, 'reason' => 'Glycation burden требует composite glycemic-aging methodology.'],
                'insulin-resistance' => ['status' => 'applicable', 'primary' => false, 'priority' => 15, 'reason' => 'Chronic glycemic burden связан с metabolic dysfunction.'],
                'cardiovascular-risk' => ['status' => 'applicable', 'primary' => false, 'priority' => 20, 'reason' => 'Glycation burden связан с vascular-aging processes.'],
                'longevity' => ['status' => 'applicable', 'primary' => true, 'priority' => 10, 'reason' => 'Glycation accumulation является важным aging-related concept.'],
            ],

            'cgm-derived-risk-score' => [
                'general-adult' => ['status' => 'needs_review', 'primary' => false, 'priority' => 99, 'reason' => 'CGM-derived risk требует dedicated continuous-data methodology.'],
                'insulin-resistance' => ['status' => 'applicable', 'primary' => true, 'priority' => 5, 'reason' => 'CGM risk patterns важны для metabolic dysfunction detection.'],
                'cardiovascular-risk' => ['status' => 'applicable', 'primary' => false, 'priority' => 15, 'reason' => 'Dynamic glucose instability может быть связана с vascular risk burden.'],
                'longevity' => ['status' => 'applicable', 'primary' => false, 'priority' => 20, 'reason' => 'Continuous metabolic resilience важна для healthy aging context.'],
            ],

            'white-cell-variability-score' => [
                'general-adult' => ['status' => 'needs_review', 'primary' => false, 'priority' => 94, 'reason' => 'WBC variability требует longitudinal immune-pattern methodology.'],
                'chronic-inflammation-risk' => ['status' => 'applicable', 'primary' => true, 'priority' => 10, 'reason' => 'Immune variability может отражать chronic inflammatory burden.'],
                'longevity' => ['status' => 'applicable', 'primary' => false, 'priority' => 20, 'reason' => 'Immune stability важна для healthy aging context.'],
            ],

            'immune-age-estimate' => [
                'general-adult' => ['status' => 'needs_review', 'primary' => false, 'priority' => 99, 'reason' => 'Immune age estimate требует composite immunosenescence methodology.'],
                'longevity' => ['status' => 'applicable', 'primary' => true, 'priority' => 5, 'reason' => 'Immune aging является core longevity domain.'],
                'senior' => ['status' => 'applicable', 'primary' => false, 'priority' => 15, 'reason' => 'Immunosenescence особенно важна в geriatric context.'],
            ],

            'immune-resilience-score' => [
                'general-adult' => ['status' => 'needs_review', 'primary' => false, 'priority' => 97, 'reason' => 'Immune resilience требует systems-immunology methodology.'],
                'longevity' => ['status' => 'applicable', 'primary' => true, 'priority' => 10, 'reason' => 'Immune adaptability важна для healthy aging context.'],
                'chronic-inflammation-risk' => ['status' => 'applicable', 'primary' => false, 'priority' => 20, 'reason' => 'Reduced immune resilience может быть связана с chronic inflammatory burden.'],
            ],

            'latent-viral-burden-score' => [
                'general-adult' => ['status' => 'needs_review', 'primary' => false, 'priority' => 98, 'reason' => 'Latent viral burden требует infectious-disease methodology.'],
                'immune-risk' => ['status' => 'applicable', 'primary' => true, 'priority' => 10, 'reason' => 'Latent viral burden может отражать immune-system stress context.'],
                'longevity' => ['status' => 'applicable', 'primary' => false, 'priority' => 20, 'reason' => 'Chronic immune activation может быть связан с aging burden.'],
            ],

            'ebv-reactivation-pattern' => [
                'general-adult' => ['status' => 'needs_review', 'primary' => false, 'priority' => 99, 'reason' => 'EBV reactivation требует infectious/immunologic methodology.'],
                'immune-risk' => ['status' => 'applicable', 'primary' => true, 'priority' => 10, 'reason' => 'EBV reactivation может быть marker immune stress/dysregulation.'],
                'chronic-fatigue-risk' => ['status' => 'applicable', 'primary' => false, 'priority' => 20, 'reason' => 'EBV burden может пересекаться с chronic fatigue context.'],
            ],

            'post-viral-recovery-score' => [
                'general-adult' => ['status' => 'needs_review', 'primary' => false, 'priority' => 96, 'reason' => 'Post-viral recovery требует longitudinal recovery methodology.'],
                'immune-risk' => ['status' => 'applicable', 'primary' => false, 'priority' => 20, 'reason' => 'Delayed recovery может отражать immune dysfunction burden.'],
                'longevity' => ['status' => 'applicable', 'primary' => true, 'priority' => 15, 'reason' => 'Recovery capacity важна для resilience/longevity context.'],
            ],

            'nk-cell-activity' => [
                'general-adult' => ['status' => 'needs_review', 'primary' => false, 'priority' => 96, 'reason' => 'NK-cell activity требует immunology-specific methodology.'],
                'immune-risk' => ['status' => 'applicable', 'primary' => true, 'priority' => 10, 'reason' => 'NK-cell function важна в innate immune surveillance context.'],
                'longevity' => ['status' => 'applicable', 'primary' => false, 'priority' => 20, 'reason' => 'Innate immune resilience может быть связана с healthy aging.'],
            ],

            't-cell-senescence-score' => [
                'general-adult' => ['status' => 'needs_review', 'primary' => false, 'priority' => 99, 'reason' => 'T-cell senescence требует advanced immunosenescence methodology.'],
                'longevity' => ['status' => 'applicable', 'primary' => true, 'priority' => 5, 'reason' => 'T-cell aging является ключевым immunosenescence concept.'],
                'senior' => ['status' => 'applicable', 'primary' => false, 'priority' => 15, 'reason' => 'T-cell senescence особенно важна в aging immune context.'],
            ],

            'inflammaging-score' => [
                'general-adult' => ['status' => 'needs_review', 'primary' => false, 'priority' => 98, 'reason' => 'Inflammaging score требует composite aging-inflammation methodology.'],
                'longevity' => ['status' => 'applicable', 'primary' => true, 'priority' => 5, 'reason' => 'Inflammaging является core healthy-aging concept.'],
                'chronic-inflammation-risk' => ['status' => 'applicable', 'primary' => false, 'priority' => 15, 'reason' => 'Chronic inflammatory burden напрямую связан с inflammaging context.'],
            ],

            'systemic-recovery-capacity' => [
                'general-adult' => ['status' => 'needs_review', 'primary' => false, 'priority' => 97, 'reason' => 'Systemic recovery capacity требует multi-system resilience methodology.'],
                'athlete' => ['status' => 'applicable', 'primary' => false, 'priority' => 20, 'reason' => 'Whole-system recovery важна в training adaptation context.'],
                'longevity' => ['status' => 'applicable', 'primary' => true, 'priority' => 10, 'reason' => 'Recovery reserve является core resilience/longevity concept.'],
                'chronic-fatigue-risk' => ['status' => 'applicable', 'primary' => false, 'priority' => 25, 'reason' => 'Reduced recovery capacity может быть связана с chronic fatigue burden.'],
            ],

            'amh' => [
                'general-adult' => ['status' => 'needs_review', 'primary' => false, 'priority' => 94, 'reason' => 'AMH требует reproductive-endocrinology methodology.'],
                'female-adult' => ['status' => 'applicable', 'primary' => true, 'priority' => 10, 'reason' => 'AMH является ключевым marker ovarian reserve.'],
                'female-postmenopause' => ['status' => 'not_applicable', 'primary' => false, 'priority' => 90, 'reason' => 'AMH теряет clinical relevance после menopause context.'],
            ],

            'ovarian-reserve-score' => [
                'general-adult' => ['status' => 'needs_review', 'primary' => false, 'priority' => 97, 'reason' => 'Ovarian reserve score требует composite reproductive methodology.'],
                'female-adult' => ['status' => 'applicable', 'primary' => true, 'priority' => 5, 'reason' => 'Ovarian reserve является core reproductive-health concept.'],
            ],

            'cycle-regularity-score' => [
                'general-adult' => ['status' => 'not_applicable', 'primary' => false, 'priority' => 95, 'reason' => 'Cycle regularity не применима вне female reproductive context.'],
                'female-adult' => ['status' => 'applicable', 'primary' => true, 'priority' => 10, 'reason' => 'Cycle regularity важна для reproductive and endocrine health context.'],
                'female-postmenopause' => ['status' => 'not_applicable', 'primary' => false, 'priority' => 90, 'reason' => 'Cycle physiology отсутствует после menopause.'],
            ],

            'ovulation-quality-score' => [
                'general-adult' => ['status' => 'not_applicable', 'primary' => false, 'priority' => 95, 'reason' => 'Ovulation quality применима только в female reproductive context.'],
                'female-adult' => ['status' => 'applicable', 'primary' => true, 'priority' => 10, 'reason' => 'Ovulatory function является ключевой частью reproductive physiology.'],
                'female-postmenopause' => ['status' => 'not_applicable', 'primary' => false, 'priority' => 95, 'reason' => 'Ovulatory physiology отсутствует после menopause.'],
            ],

            'pcos-risk-score' => [
                'general-adult' => ['status' => 'not_applicable', 'primary' => false, 'priority' => 95, 'reason' => 'PCOS risk применим только в female endocrine context.'],
                'female-adult' => ['status' => 'applicable', 'primary' => true, 'priority' => 5, 'reason' => 'PCOS risk является важным reproductive-metabolic concept.'],
                'insulin-resistance' => ['status' => 'applicable', 'primary' => false, 'priority' => 15, 'reason' => 'PCOS тесно связан с insulin resistance context.'],
            ],

            'endometriosis-risk-pattern' => [
                'general-adult' => ['status' => 'not_applicable', 'primary' => false, 'priority' => 96, 'reason' => 'Endometriosis risk не применим вне female reproductive context.'],
                'female-adult' => ['status' => 'applicable', 'primary' => true, 'priority' => 10, 'reason' => 'Endometriosis относится к chronic inflammatory reproductive context.'],
                'chronic-inflammation-risk' => ['status' => 'applicable', 'primary' => false, 'priority' => 25, 'reason' => 'Endometriosis может пересекаться с chronic inflammatory burden.'],
            ],

            'menopause-transition-score' => [
                'general-adult' => ['status' => 'not_applicable', 'primary' => false, 'priority' => 97, 'reason' => 'Menopause transition применим только в female aging context.'],
                'female-postmenopause' => ['status' => 'applicable', 'primary' => true, 'priority' => 5, 'reason' => 'Menopause transition является core female-aging domain.'],
                'longevity' => ['status' => 'applicable', 'primary' => false, 'priority' => 20, 'reason' => 'Hormonal aging transition важен для female longevity context.'],
            ],

            'hormonal-resilience-score' => [
                'general-adult' => ['status' => 'needs_review', 'primary' => false, 'priority' => 94, 'reason' => 'Hormonal resilience требует endocrine-network methodology.'],
                'female-adult' => ['status' => 'applicable', 'primary' => false, 'priority' => 20, 'reason' => 'Hormonal adaptability важна в female endocrine physiology.'],
                'longevity' => ['status' => 'applicable', 'primary' => true, 'priority' => 15, 'reason' => 'Endocrine resilience важна для healthy aging context.'],
            ],

            'pregnancy-metabolic-risk-score' => [
                'general-adult' => ['status' => 'not_applicable', 'primary' => false, 'priority' => 98, 'reason' => 'Pregnancy metabolic risk применим только в pregnancy context.'],
                'female-pregnant' => ['status' => 'applicable', 'primary' => true, 'priority' => 5, 'reason' => 'Pregnancy metabolic adaptation является ключевым maternal-health domain.'],
                'insulin-resistance' => ['status' => 'applicable', 'primary' => false, 'priority' => 15, 'reason' => 'Gestational metabolic dysfunction связан с insulin-resistance context.'],
            ],

            'female-longevity-score' => [
                'general-adult' => ['status' => 'needs_review', 'primary' => false, 'priority' => 98, 'reason' => 'Female longevity score требует sex-specific aging methodology.'],
                'female-postmenopause' => ['status' => 'applicable', 'primary' => false, 'priority' => 20, 'reason' => 'Hormonal aging transition влияет на female longevity trajectory.'],
                'longevity' => ['status' => 'applicable', 'primary' => true, 'priority' => 5, 'reason' => 'Female-specific longevity physiology требует отдельного modeling layer.'],
            ],

            'free-androgen-index' => [
                'general-adult' => ['status' => 'needs_review', 'primary' => false, 'priority' => 92, 'reason' => 'Free androgen index требует endocrine-specific interpretation methodology.'],
                'male-adult' => ['status' => 'applicable', 'primary' => true, 'priority' => 10, 'reason' => 'FAI важен для androgen-status assessment у мужчин.'],
                'female-adult' => ['status' => 'applicable', 'primary' => false, 'priority' => 20, 'reason' => 'FAI может использоваться в female hyperandrogenism context.'],
            ],

            'shbg' => [
                'general-adult' => ['status' => 'applicable', 'primary' => false, 'priority' => 30, 'reason' => 'SHBG используется как endocrine-metabolic transport marker.'],
                'male-adult' => ['status' => 'applicable', 'primary' => true, 'priority' => 10, 'reason' => 'SHBG важен для корректной androgen interpretation у мужчин.'],
                'insulin-resistance' => ['status' => 'applicable', 'primary' => false, 'priority' => 20, 'reason' => 'SHBG связан с metabolic and insulin-resistance context.'],
                'female-adult' => ['status' => 'applicable', 'primary' => false, 'priority' => 30, 'reason' => 'SHBG может быть важен в female endocrine context.'],
            ],

            'male-hormonal-age-score' => [
                'general-adult' => ['status' => 'needs_review', 'primary' => false, 'priority' => 97, 'reason' => 'Male hormonal age требует sex-specific endocrine-aging methodology.'],
                'male-adult' => ['status' => 'applicable', 'primary' => true, 'priority' => 5, 'reason' => 'Hormonal aging является core male-health domain.'],
                'longevity' => ['status' => 'applicable', 'primary' => false, 'priority' => 15, 'reason' => 'Androgen-aging trajectory важна для male longevity context.'],
            ],

            'androgen-resilience-score' => [
                'general-adult' => ['status' => 'needs_review', 'primary' => false, 'priority' => 96, 'reason' => 'Androgen resilience требует endocrine-network methodology.'],
                'male-adult' => ['status' => 'applicable', 'primary' => true, 'priority' => 10, 'reason' => 'Androgen resilience важна для male vitality/recovery context.'],
                'athlete' => ['status' => 'applicable', 'primary' => false, 'priority' => 20, 'reason' => 'Androgen adaptation может быть важна в performance/recovery context.'],
                'longevity' => ['status' => 'applicable', 'primary' => false, 'priority' => 25, 'reason' => 'Hormonal resilience связана с healthy aging context.'],
            ],

            'fertility-potential-score' => [
                'general-adult' => ['status' => 'needs_review', 'primary' => false, 'priority' => 97, 'reason' => 'Fertility potential требует reproductive composite methodology.'],
                'male-adult' => ['status' => 'applicable', 'primary' => true, 'priority' => 15, 'reason' => 'Male reproductive potential является важным reproductive-health domain.'],
                'female-adult' => ['status' => 'applicable', 'primary' => false, 'priority' => 15, 'reason' => 'Female reproductive reserve может входить в fertility assessment context.'],
            ],

            'sperm-quality-score' => [
                'general-adult' => ['status' => 'not_applicable', 'primary' => false, 'priority' => 98, 'reason' => 'Sperm-quality assessment применим только в male reproductive context.'],
                'male-adult' => ['status' => 'applicable', 'primary' => true, 'priority' => 5, 'reason' => 'Sperm quality является core male reproductive-health marker.'],
                'longevity' => ['status' => 'applicable', 'primary' => false, 'priority' => 25, 'reason' => 'Reproductive integrity может пересекаться с systemic-health context.'],
            ],

            'erectile-function-risk-score' => [
                'general-adult' => ['status' => 'not_applicable', 'primary' => false, 'priority' => 98, 'reason' => 'ED-risk assessment применим преимущественно в male vascular-health context.'],
                'male-adult' => ['status' => 'applicable', 'primary' => true, 'priority' => 10, 'reason' => 'Erectile-function risk связан с androgen and vascular-health context.'],
                'cardiovascular-risk' => ['status' => 'applicable', 'primary' => false, 'priority' => 15, 'reason' => 'ED-risk может быть ранним marker vascular dysfunction.'],
            ],

            'prostate-risk-pattern' => [
                'general-adult' => ['status' => 'not_applicable', 'primary' => false, 'priority' => 99, 'reason' => 'Prostate-risk interpretation применима только в male-health context.'],
                'male-adult' => ['status' => 'applicable', 'primary' => true, 'priority' => 5, 'reason' => 'Prostate-health является core male-aging domain.'],
                'senior' => ['status' => 'applicable', 'primary' => false, 'priority' => 15, 'reason' => 'Возраст связан с prostate-risk progression context.'],
            ],

            'androgen-metabolic-balance-score' => [
                'general-adult' => ['status' => 'needs_review', 'primary' => false, 'priority' => 97, 'reason' => 'Androgen-metabolic balance требует composite endocrine-metabolic methodology.'],
                'male-adult' => ['status' => 'applicable', 'primary' => true, 'priority' => 10, 'reason' => 'Androgen-metabolic coupling важен для male systemic-health context.'],
                'insulin-resistance' => ['status' => 'applicable', 'primary' => false, 'priority' => 20, 'reason' => 'Metabolic dysfunction тесно связан с androgen balance.'],
                'longevity' => ['status' => 'applicable', 'primary' => false, 'priority' => 25, 'reason' => 'Hormonal-metabolic integrity важна для healthy aging context.'],
            ],

            'male-vitality-score' => [
                'general-adult' => ['status' => 'needs_review', 'primary' => false, 'priority' => 98, 'reason' => 'Male vitality требует composite physiologic-endocrine methodology.'],
                'male-adult' => ['status' => 'applicable', 'primary' => true, 'priority' => 5, 'reason' => 'Male vitality объединяет endocrine, metabolic и recovery domains.'],
                'longevity' => ['status' => 'applicable', 'primary' => false, 'priority' => 15, 'reason' => 'Vitality reserve важна для male healthy-aging context.'],
                'athlete' => ['status' => 'applicable', 'primary' => false, 'priority' => 25, 'reason' => 'Performance/recovery capacity может пересекаться с vitality context.'],
            ],

            'microbiome-diversity-score' => [
                'general-adult' => ['status' => 'needs_review', 'primary' => false, 'priority' => 97, 'reason' => 'Microbiome diversity требует microbiome-specific interpretation methodology.'],
                'longevity' => ['status' => 'applicable', 'primary' => true, 'priority' => 10, 'reason' => 'Microbiome diversity связана с healthy-aging and resilience context.'],
                'chronic-inflammation-risk' => ['status' => 'applicable', 'primary' => false, 'priority' => 20, 'reason' => 'Reduced microbiome diversity может быть связана с inflammatory burden.'],
            ],

            'butyrate-production-score' => [
                'general-adult' => ['status' => 'needs_review', 'primary' => false, 'priority' => 96, 'reason' => 'Butyrate production требует microbiome-metabolite methodology.'],
                'gut-health-risk' => ['status' => 'applicable', 'primary' => true, 'priority' => 10, 'reason' => 'Butyrate production важна для gut-barrier and colon-health context.'],
                'longevity' => ['status' => 'applicable', 'primary' => false, 'priority' => 20, 'reason' => 'SCFA metabolism может быть связан с healthy aging context.'],
            ],

            'gut-permeability-score' => [
                'general-adult' => ['status' => 'needs_review', 'primary' => false, 'priority' => 97, 'reason' => 'Gut permeability требует gut-barrier methodology.'],
                'gut-health-risk' => ['status' => 'applicable', 'primary' => true, 'priority' => 5, 'reason' => 'Gut-barrier integrity является core gut-health domain.'],
                'autoimmune-risk' => ['status' => 'applicable', 'primary' => false, 'priority' => 20, 'reason' => 'Gut permeability может пересекаться с autoimmune-inflammatory context.'],
                'chronic-inflammation-risk' => ['status' => 'applicable', 'primary' => false, 'priority' => 25, 'reason' => 'Barrier dysfunction может быть связан с systemic inflammatory burden.'],
            ],

            'zonulin' => [
                'general-adult' => ['status' => 'needs_review', 'primary' => false, 'priority' => 96, 'reason' => 'Zonulin interpretation требует stronger evidence framework and gut-barrier methodology.'],
                'gut-health-risk' => ['status' => 'applicable', 'primary' => true, 'priority' => 10, 'reason' => 'Zonulin может использоваться в gut-permeability context.'],
            ],

            'short-chain-fatty-acid-profile' => [
                'general-adult' => ['status' => 'needs_review', 'primary' => false, 'priority' => 97, 'reason' => 'SCFA profile требует microbiome-metabolic methodology.'],
                'gut-health-risk' => ['status' => 'applicable', 'primary' => true, 'priority' => 10, 'reason' => 'SCFA production важна для gut-metabolic ecology.'],
                'longevity' => ['status' => 'applicable', 'primary' => false, 'priority' => 20, 'reason' => 'Microbial metabolite balance может быть связан с healthy aging.'],
            ],

            'gut-inflammation-score' => [
                'general-adult' => ['status' => 'needs_review', 'primary' => false, 'priority' => 97, 'reason' => 'Gut inflammation score требует composite GI-inflammatory methodology.'],
                'gut-health-risk' => ['status' => 'applicable', 'primary' => true, 'priority' => 5, 'reason' => 'Gut inflammatory burden является core GI-health domain.'],
                'chronic-inflammation-risk' => ['status' => 'applicable', 'primary' => false, 'priority' => 15, 'reason' => 'GI inflammation может влиять на systemic inflammatory load.'],
            ],

            'microbiome-resilience-score' => [
                'general-adult' => ['status' => 'needs_review', 'primary' => false, 'priority' => 98, 'reason' => 'Microbiome resilience требует longitudinal microbiome methodology.'],
                'longevity' => ['status' => 'applicable', 'primary' => true, 'priority' => 10, 'reason' => 'Microbiome adaptability важна для healthy-aging resilience context.'],
                'gut-health-risk' => ['status' => 'applicable', 'primary' => false, 'priority' => 20, 'reason' => 'Microbial stability важна для gut-health maintenance.'],
            ],

            'brain-gut-axis-score' => [
                'general-adult' => ['status' => 'needs_review', 'primary' => false, 'priority' => 99, 'reason' => 'Brain-gut axis modeling требует neuro-gastroenterology methodology.'],
                'neurologic-risk' => ['status' => 'applicable', 'primary' => false, 'priority' => 20, 'reason' => 'Gut-brain interaction может быть важна в neuroinflammatory context.'],
                'gut-health-risk' => ['status' => 'applicable', 'primary' => true, 'priority' => 10, 'reason' => 'Brain-gut signaling является частью gut-system regulation.'],
                'longevity' => ['status' => 'applicable', 'primary' => false, 'priority' => 25, 'reason' => 'Neuro-metabolic resilience может пересекаться с gut-brain context.'],
            ],

            'post-antibiotic-recovery-score' => [
                'general-adult' => ['status' => 'needs_review', 'primary' => false, 'priority' => 98, 'reason' => 'Post-antibiotic recovery требует microbiome-recovery methodology.'],
                'gut-health-risk' => ['status' => 'applicable', 'primary' => true, 'priority' => 15, 'reason' => 'Microbiome recovery capacity важна после antibiotic exposure.'],
                'immune-risk' => ['status' => 'applicable', 'primary' => false, 'priority' => 25, 'reason' => 'Gut microbiome recovery может влиять на immune-system resilience.'],
            ],

            'microbial-metabolic-flexibility-score' => [
                'general-adult' => ['status' => 'needs_review', 'primary' => false, 'priority' => 99, 'reason' => 'Microbial metabolic flexibility требует systems-biology microbiome methodology.'],
                'gut-health-risk' => ['status' => 'applicable', 'primary' => false, 'priority' => 20, 'reason' => 'Adaptive microbial metabolism важна для gut ecosystem stability.'],
                'longevity' => ['status' => 'applicable', 'primary' => true, 'priority' => 10, 'reason' => 'Microbial adaptability может быть частью resilience/longevity context.'],
                'insulin-resistance' => ['status' => 'applicable', 'primary' => false, 'priority' => 30, 'reason' => 'Gut microbiome flexibility может быть связана с metabolic regulation.'],
            ],

            'protein-adequacy-score' => [
                'general-adult' => ['status' => 'applicable', 'primary' => false, 'priority' => 30, 'reason' => 'Protein adequacy используется как nutritional sufficiency marker.'],
                'athlete' => ['status' => 'applicable', 'primary' => true, 'priority' => 10, 'reason' => 'Protein sufficiency критически важна для recovery and adaptation context.'],
                'senior' => ['status' => 'applicable', 'primary' => false, 'priority' => 15, 'reason' => 'Protein intake важен для sarcopenia prevention context.'],
                'longevity' => ['status' => 'applicable', 'primary' => false, 'priority' => 20, 'reason' => 'Nutritional resilience важна для healthy aging context.'],
            ],

            'anabolic-reserve-score' => [
                'general-adult' => ['status' => 'needs_review', 'primary' => false, 'priority' => 97, 'reason' => 'Anabolic reserve требует composite endocrine-muscle methodology.'],
                'athlete' => ['status' => 'applicable', 'primary' => true, 'priority' => 5, 'reason' => 'Anabolic reserve важен для training adaptation context.'],
                'senior' => ['status' => 'applicable', 'primary' => false, 'priority' => 15, 'reason' => 'Anabolic reserve важен для muscle-preservation and frailty prevention.'],
                'longevity' => ['status' => 'applicable', 'primary' => false, 'priority' => 20, 'reason' => 'Anabolic resilience важна для healthy aging trajectory.'],
            ],

            'catabolic-load-score' => [
                'general-adult' => ['status' => 'needs_review', 'primary' => false, 'priority' => 96, 'reason' => 'Catabolic load требует stress-recovery physiology methodology.'],
                'athlete' => ['status' => 'applicable', 'primary' => true, 'priority' => 10, 'reason' => 'Catabolic stress важен для overreaching/recovery context.'],
                'chronic-fatigue-risk' => ['status' => 'applicable', 'primary' => false, 'priority' => 20, 'reason' => 'Persistent catabolic burden может быть связан с chronic fatigue context.'],
                'longevity' => ['status' => 'applicable', 'primary' => false, 'priority' => 25, 'reason' => 'Catabolic burden влияет на resilience and aging trajectory.'],
            ],

            'nitrogen-balance-estimate' => [
                'general-adult' => ['status' => 'needs_review', 'primary' => false, 'priority' => 94, 'reason' => 'Nitrogen balance требует nutritional-metabolic methodology.'],
                'athlete' => ['status' => 'applicable', 'primary' => true, 'priority' => 10, 'reason' => 'Nitrogen balance важен для recovery and muscle adaptation.'],
                'senior' => ['status' => 'applicable', 'primary' => false, 'priority' => 20, 'reason' => 'Protein preservation важна в aging-muscle context.'],
            ],

            'meal-recovery-efficiency-score' => [
                'general-adult' => ['status' => 'needs_review', 'primary' => false, 'priority' => 97, 'reason' => 'Meal recovery efficiency требует longitudinal nutritional-response methodology.'],
                'athlete' => ['status' => 'applicable', 'primary' => true, 'priority' => 5, 'reason' => 'Nutritional recovery efficiency важна для performance adaptation.'],
                'insulin-resistance' => ['status' => 'applicable', 'primary' => false, 'priority' => 20, 'reason' => 'Meal-response recovery связан с metabolic flexibility context.'],
            ],

            'amino-acid-balance-score' => [
                'general-adult' => ['status' => 'needs_review', 'primary' => false, 'priority' => 96, 'reason' => 'Amino-acid balance требует metabolomics/nutrition methodology.'],
                'athlete' => ['status' => 'applicable', 'primary' => false, 'priority' => 20, 'reason' => 'Amino-acid sufficiency важна для recovery and adaptation context.'],
                'longevity' => ['status' => 'applicable', 'primary' => true, 'priority' => 15, 'reason' => 'Protein-quality balance может быть связан с healthy aging context.'],
            ],

            'muscle-preservation-score' => [
                'general-adult' => ['status' => 'applicable', 'primary' => false, 'priority' => 35, 'reason' => 'Muscle preservation используется как functional resilience marker.'],
                'senior' => ['status' => 'applicable', 'primary' => true, 'priority' => 5, 'reason' => 'Muscle preservation критически важно в sarcopenia-prevention context.'],
                'athlete' => ['status' => 'applicable', 'primary' => false, 'priority' => 15, 'reason' => 'Muscle retention важно для performance stability.'],
                'longevity' => ['status' => 'applicable', 'primary' => false, 'priority' => 20, 'reason' => 'Lean-mass preservation связано с healthy aging trajectory.'],
            ],

            'nutritional-resilience-score' => [
                'general-adult' => ['status' => 'needs_review', 'primary' => false, 'priority' => 98, 'reason' => 'Nutritional resilience требует systems-nutrition methodology.'],
                'longevity' => ['status' => 'applicable', 'primary' => true, 'priority' => 10, 'reason' => 'Adaptive nutritional resilience важна для healthy aging context.'],
                'athlete' => ['status' => 'applicable', 'primary' => false, 'priority' => 20, 'reason' => 'Nutritional adaptability важна для recovery/performance context.'],
                'chronic-fatigue-risk' => ['status' => 'applicable', 'primary' => false, 'priority' => 25, 'reason' => 'Poor nutritional resilience может усиливать chronic fatigue burden.'],
            ],

            'refeeding-response-score' => [
                'general-adult' => ['status' => 'needs_review', 'primary' => false, 'priority' => 99, 'reason' => 'Refeeding response требует clinical nutrition methodology.'],
                'chronic-fatigue-risk' => ['status' => 'applicable', 'primary' => false, 'priority' => 20, 'reason' => 'Recovery nutrition может быть связана с fatigue-recovery context.'],
                'athlete' => ['status' => 'applicable', 'primary' => true, 'priority' => 15, 'reason' => 'Refeeding adaptation важна после high training load.'],
            ],

            'energy-availability-score' => [
                'general-adult' => ['status' => 'needs_review', 'primary' => false, 'priority' => 98, 'reason' => 'Energy availability требует exercise-nutrition methodology.'],
                'athlete' => ['status' => 'applicable', 'primary' => true, 'priority' => 5, 'reason' => 'Energy availability является core athlete-recovery domain.'],
                'female-adult' => ['status' => 'applicable', 'primary' => false, 'priority' => 20, 'reason' => 'Low energy availability может влиять на reproductive-endocrine health.'],
                'longevity' => ['status' => 'applicable', 'primary' => false, 'priority' => 30, 'reason' => 'Energetic resilience важна для long-term physiologic stability.'],
            ],

            'behavioral-consistency-score' => [
                'general-adult' => ['status' => 'needs_review', 'primary' => false, 'priority' => 96, 'reason' => 'Behavioral consistency требует longitudinal lifestyle-pattern methodology.'],
                'longevity' => ['status' => 'applicable', 'primary' => true, 'priority' => 10, 'reason' => 'Stable healthy behaviors важны для long-term resilience and aging trajectory.'],
                'athlete' => ['status' => 'applicable', 'primary' => false, 'priority' => 20, 'reason' => 'Training consistency важна для adaptive performance context.'],
            ],

            'circadian-consistency-score' => [
                'general-adult' => ['status' => 'needs_review', 'primary' => false, 'priority' => 95, 'reason' => 'Circadian consistency требует sleep/circadian longitudinal methodology.'],
                'longevity' => ['status' => 'applicable', 'primary' => true, 'priority' => 5, 'reason' => 'Stable circadian alignment важна для healthy aging context.'],
                'athlete' => ['status' => 'applicable', 'primary' => false, 'priority' => 15, 'reason' => 'Circadian stability влияет на recovery/performance adaptation.'],
            ],

            'meal-timing-stability-score' => [
                'general-adult' => ['status' => 'needs_review', 'primary' => false, 'priority' => 94, 'reason' => 'Meal timing stability требует chrono-nutrition methodology.'],
                'insulin-resistance' => ['status' => 'applicable', 'primary' => true, 'priority' => 10, 'reason' => 'Meal timing связан с metabolic regulation context.'],
                'longevity' => ['status' => 'applicable', 'primary' => false, 'priority' => 20, 'reason' => 'Chrononutrition patterns могут влиять на healthy aging trajectory.'],
            ],

            'physical-activity-resilience-score' => [
                'general-adult' => ['status' => 'applicable', 'primary' => false, 'priority' => 35, 'reason' => 'Physical-activity resilience отражает adaptive movement capacity.'],
                'athlete' => ['status' => 'applicable', 'primary' => true, 'priority' => 5, 'reason' => 'Adaptive training resilience является core athlete domain.'],
                'longevity' => ['status' => 'applicable', 'primary' => false, 'priority' => 15, 'reason' => 'Movement resilience важна для healthy aging context.'],
                'senior' => ['status' => 'applicable', 'primary' => false, 'priority' => 20, 'reason' => 'Movement capacity важна для frailty prevention context.'],
            ],

            'sedentary-load-score' => [
                'general-adult' => ['status' => 'applicable', 'primary' => true, 'priority' => 15, 'reason' => 'Sedentary burden является важным lifestyle-risk marker.'],
                'cardiovascular-risk' => ['status' => 'applicable', 'primary' => false, 'priority' => 20, 'reason' => 'Sedentary behavior связан с cardiovascular risk burden.'],
                'insulin-resistance' => ['status' => 'applicable', 'primary' => false, 'priority' => 25, 'reason' => 'Physical inactivity связана с metabolic dysfunction context.'],
                'longevity' => ['status' => 'applicable', 'primary' => false, 'priority' => 30, 'reason' => 'Movement insufficiency влияет на healthy aging trajectory.'],
            ],

            'daily-recovery-rhythm-score' => [
                'general-adult' => ['status' => 'needs_review', 'primary' => false, 'priority' => 97, 'reason' => 'Recovery rhythm требует longitudinal autonomic methodology.'],
                'athlete' => ['status' => 'applicable', 'primary' => true, 'priority' => 10, 'reason' => 'Recovery rhythm важен для load-adaptation management.'],
                'longevity' => ['status' => 'applicable', 'primary' => false, 'priority' => 15, 'reason' => 'Stable recovery rhythms важны для resilience and healthy aging.'],
            ],

            'stress-recovery-balance-score' => [
                'general-adult' => ['status' => 'needs_review', 'primary' => false, 'priority' => 96, 'reason' => 'Stress-recovery balance требует integrated physiologic methodology.'],
                'athlete' => ['status' => 'applicable', 'primary' => true, 'priority' => 5, 'reason' => 'Load-recovery balance является core athlete adaptation concept.'],
                'chronic-fatigue-risk' => ['status' => 'applicable', 'primary' => false, 'priority' => 15, 'reason' => 'Recovery imbalance может быть связана с fatigue burden.'],
                'longevity' => ['status' => 'applicable', 'primary' => false, 'priority' => 20, 'reason' => 'Adaptive stress regulation важна для healthy aging context.'],
            ],

            'lifestyle-friction-score' => [
                'general-adult' => ['status' => 'needs_review', 'primary' => false, 'priority' => 98, 'reason' => 'Lifestyle friction требует behavioral-systems methodology.'],
                'longevity' => ['status' => 'applicable', 'primary' => true, 'priority' => 15, 'reason' => 'High behavioral friction может снижать long-term resilience capacity.'],
                'chronic-fatigue-risk' => ['status' => 'applicable', 'primary' => false, 'priority' => 20, 'reason' => 'Lifestyle instability может усиливать chronic fatigue burden.'],
            ],

            'adaptive-capacity-score' => [
                'general-adult' => ['status' => 'needs_review', 'primary' => false, 'priority' => 99, 'reason' => 'Adaptive capacity требует multi-system resilience methodology.'],
                'longevity' => ['status' => 'applicable', 'primary' => true, 'priority' => 5, 'reason' => 'Adaptive reserve является core resilience/longevity domain.'],
                'athlete' => ['status' => 'applicable', 'primary' => false, 'priority' => 15, 'reason' => 'Physiologic adaptability важна для performance and recovery context.'],
                'chronic-inflammation-risk' => ['status' => 'applicable', 'primary' => false, 'priority' => 25, 'reason' => 'Reduced adaptive reserve может пересекаться с inflammatory burden.'],
            ],

            'healthspan-trajectory-score' => [
                'general-adult' => ['status' => 'needs_review', 'primary' => false, 'priority' => 99, 'reason' => 'Healthspan trajectory требует longitudinal systems-health methodology.'],
                'longevity' => ['status' => 'applicable', 'primary' => true, 'priority' => 5, 'reason' => 'Healthspan trajectory является core longevity systems concept.'],
                'senior' => ['status' => 'applicable', 'primary' => false, 'priority' => 15, 'reason' => 'Functional aging trajectory особенно важна в senior-health context.'],
            ],

            'air-quality-burden-score' => [
                'general-adult' => ['status' => 'needs_review', 'primary' => false, 'priority' => 96, 'reason' => 'Air-quality burden требует environmental exposure methodology.'],
                'cardiovascular-risk' => ['status' => 'applicable', 'primary' => false, 'priority' => 20, 'reason' => 'Air pollution burden связан с vascular-inflammatory stress context.'],
                'respiratory-risk' => ['status' => 'applicable', 'primary' => true, 'priority' => 10, 'reason' => 'Air-quality exposure является core respiratory-burden domain.'],
                'longevity' => ['status' => 'applicable', 'primary' => false, 'priority' => 25, 'reason' => 'Environmental exposure load влияет на healthy aging trajectory.'],
            ],

            'noise-stress-load-score' => [
                'general-adult' => ['status' => 'needs_review', 'primary' => false, 'priority' => 95, 'reason' => 'Noise-stress modeling требует environmental-stress methodology.'],
                'cardiovascular-risk' => ['status' => 'applicable', 'primary' => false, 'priority' => 25, 'reason' => 'Chronic noise exposure может усиливать autonomic/cardiovascular burden.'],
                'longevity' => ['status' => 'applicable', 'primary' => true, 'priority' => 15, 'reason' => 'Environmental stress accumulation влияет на resilience and aging.'],
            ],

            'light-exposure-alignment-score' => [
                'general-adult' => ['status' => 'needs_review', 'primary' => false, 'priority' => 96, 'reason' => 'Light-exposure alignment требует circadian-environment methodology.'],
                'longevity' => ['status' => 'applicable', 'primary' => true, 'priority' => 10, 'reason' => 'Circadian light alignment важна для healthy aging and recovery context.'],
                'athlete' => ['status' => 'applicable', 'primary' => false, 'priority' => 20, 'reason' => 'Light/circadian regulation влияет на recovery and performance adaptation.'],
            ],

            'altitude-adaptation-score' => [
                'general-adult' => ['status' => 'needs_review', 'primary' => false, 'priority' => 97, 'reason' => 'Altitude adaptation требует environmental physiology methodology.'],
                'athlete' => ['status' => 'applicable', 'primary' => true, 'priority' => 15, 'reason' => 'Altitude adaptation важна в endurance/performance context.'],
                'respiratory-risk' => ['status' => 'applicable', 'primary' => false, 'priority' => 25, 'reason' => 'Altitude stress может быть значим в respiratory reserve context.'],
            ],

            'temperature-resilience-score' => [
                'general-adult' => ['status' => 'needs_review', 'primary' => false, 'priority' => 96, 'reason' => 'Temperature resilience требует thermoregulation methodology.'],
                'longevity' => ['status' => 'applicable', 'primary' => true, 'priority' => 15, 'reason' => 'Thermoregulatory resilience важна для adaptive aging context.'],
                'senior' => ['status' => 'applicable', 'primary' => false, 'priority' => 20, 'reason' => 'Temperature resilience становится более значимой с aging/frailty burden.'],
            ],

            'urban-stress-burden-score' => [
                'general-adult' => ['status' => 'needs_review', 'primary' => false, 'priority' => 98, 'reason' => 'Urban stress burden требует socio-environmental systems methodology.'],
                'chronic-fatigue-risk' => ['status' => 'applicable', 'primary' => false, 'priority' => 20, 'reason' => 'High environmental stress load может усиливать chronic fatigue burden.'],
                'longevity' => ['status' => 'applicable', 'primary' => true, 'priority' => 10, 'reason' => 'Urban stress ecology влияет на resilience and healthy aging.'],
            ],

            'nature-exposure-score' => [
                'general-adult' => ['status' => 'needs_review', 'primary' => false, 'priority' => 94, 'reason' => 'Nature exposure требует behavioral-environmental methodology.'],
                'longevity' => ['status' => 'applicable', 'primary' => true, 'priority' => 15, 'reason' => 'Nature exposure может поддерживать resilience and recovery capacity.'],
                'mental-health-risk' => ['status' => 'applicable', 'primary' => false, 'priority' => 25, 'reason' => 'Nature exposure может пересекаться с stress-reduction context.'],
            ],

            'travel-recovery-burden-score' => [
                'general-adult' => ['status' => 'needs_review', 'primary' => false, 'priority' => 97, 'reason' => 'Travel-recovery burden требует circadian/environment adaptation methodology.'],
                'athlete' => ['status' => 'applicable', 'primary' => false, 'priority' => 25, 'reason' => 'Travel burden влияет на performance and recovery adaptation.'],
                'longevity' => ['status' => 'applicable', 'primary' => true, 'priority' => 20, 'reason' => 'Recovery disruption может снижать resilience capacity.'],
            ],

            'seasonal-adaptation-score' => [
                'general-adult' => ['status' => 'needs_review', 'primary' => false, 'priority' => 95, 'reason' => 'Seasonal adaptation требует environmental-physiology methodology.'],
                'longevity' => ['status' => 'applicable', 'primary' => true, 'priority' => 15, 'reason' => 'Adaptive physiologic flexibility важна для healthy aging context.'],
                'immune-risk' => ['status' => 'applicable', 'primary' => false, 'priority' => 25, 'reason' => 'Seasonal physiologic stress может пересекаться с immune resilience context.'],
            ],

            'environmental-resilience-score' => [
                'general-adult' => ['status' => 'needs_review', 'primary' => false, 'priority' => 99, 'reason' => 'Environmental resilience требует integrated systems-environment methodology.'],
                'longevity' => ['status' => 'applicable', 'primary' => true, 'priority' => 5, 'reason' => 'Environmental adaptability является core resilience/longevity concept.'],
                'athlete' => ['status' => 'applicable', 'primary' => false, 'priority' => 20, 'reason' => 'Environmental adaptability влияет на performance and recovery capacity.'],
                'chronic-inflammation-risk' => ['status' => 'applicable', 'primary' => false, 'priority' => 30, 'reason' => 'Environmental stress accumulation может усиливать inflammatory burden.'],
            ],

            'cognitive-fatigue-score' => [
                'general-adult' => ['status' => 'needs_review', 'primary' => false, 'priority' => 97, 'reason' => 'Cognitive fatigue требует neurobehavioral longitudinal methodology.'],
                'chronic-fatigue-risk' => ['status' => 'applicable', 'primary' => true, 'priority' => 10, 'reason' => 'Cognitive fatigue является core chronic-fatigue domain.'],
                'longevity' => ['status' => 'applicable', 'primary' => false, 'priority' => 20, 'reason' => 'Cognitive energy stability важна для healthy aging context.'],
            ],

            'mental-recovery-score' => [
                'general-adult' => ['status' => 'needs_review', 'primary' => false, 'priority' => 96, 'reason' => 'Mental recovery требует psychophysiologic methodology.'],
                'chronic-fatigue-risk' => ['status' => 'applicable', 'primary' => false, 'priority' => 15, 'reason' => 'Reduced mental recovery может быть связана с chronic fatigue burden.'],
                'longevity' => ['status' => 'applicable', 'primary' => true, 'priority' => 10, 'reason' => 'Psychophysiologic recovery capacity важна для resilience/longevity context.'],
                'athlete' => ['status' => 'applicable', 'primary' => false, 'priority' => 25, 'reason' => 'Mental recovery влияет на performance adaptation and stress regulation.'],
            ],

            'burnout-risk-pattern' => [
                'general-adult' => ['status' => 'needs_review', 'primary' => false, 'priority' => 98, 'reason' => 'Burnout-risk modeling требует behavioral-physiology methodology.'],
                'chronic-fatigue-risk' => ['status' => 'applicable', 'primary' => true, 'priority' => 5, 'reason' => 'Burnout burden тесно связан с chronic recovery impairment.'],
                'longevity' => ['status' => 'applicable', 'primary' => false, 'priority' => 15, 'reason' => 'Chronic stress exhaustion влияет на long-term resilience trajectory.'],
            ],

            'focus-stability-score' => [
                'general-adult' => ['status' => 'needs_review', 'primary' => false, 'priority' => 95, 'reason' => 'Focus stability требует cognitive-performance methodology.'],
                'neurologic-risk' => ['status' => 'applicable', 'primary' => false, 'priority' => 20, 'reason' => 'Attention regulation может пересекаться с neurocognitive-risk context.'],
                'longevity' => ['status' => 'applicable', 'primary' => true, 'priority' => 15, 'reason' => 'Cognitive stability важна для healthy aging and neuroresilience.'],
            ],

            'emotional-regulation-score' => [
                'general-adult' => ['status' => 'needs_review', 'primary' => false, 'priority' => 97, 'reason' => 'Emotional regulation требует psychophysiologic methodology.'],
                'mental-health-risk' => ['status' => 'applicable', 'primary' => true, 'priority' => 10, 'reason' => 'Emotional regulation важна в stress and mental-health resilience context.'],
                'longevity' => ['status' => 'applicable', 'primary' => false, 'priority' => 20, 'reason' => 'Psychological resilience влияет на long-term healthspan trajectory.'],
            ],

            'decision-fatigue-score' => [
                'general-adult' => ['status' => 'needs_review', 'primary' => false, 'priority' => 98, 'reason' => 'Decision fatigue требует behavioral-cognitive methodology.'],
                'chronic-fatigue-risk' => ['status' => 'applicable', 'primary' => false, 'priority' => 20, 'reason' => 'Decision overload может усиливать recovery impairment context.'],
                'mental-health-risk' => ['status' => 'applicable', 'primary' => true, 'priority' => 15, 'reason' => 'Cognitive overload важен в stress-regulation context.'],
            ],

            'autonomic-stress-reactivity-score' => [
                'general-adult' => ['status' => 'needs_review', 'primary' => false, 'priority' => 97, 'reason' => 'Autonomic stress reactivity требует HRV/autonomic methodology.'],
                'cardiovascular-risk' => ['status' => 'applicable', 'primary' => false, 'priority' => 20, 'reason' => 'Stress-reactivity burden связан с autonomic cardiovascular stress.'],
                'mental-health-risk' => ['status' => 'applicable', 'primary' => true, 'priority' => 10, 'reason' => 'Autonomic stress sensitivity важна для psychophysiologic resilience.'],
                'longevity' => ['status' => 'applicable', 'primary' => false, 'priority' => 25, 'reason' => 'Adaptive autonomic flexibility важна для healthy aging context.'],
            ],

            'neuro-resilience-score' => [
                'general-adult' => ['status' => 'needs_review', 'primary' => false, 'priority' => 99, 'reason' => 'Neuro-resilience требует integrated neurophysiology methodology.'],
                'neurologic-risk' => ['status' => 'applicable', 'primary' => false, 'priority' => 20, 'reason' => 'Neuroadaptive reserve важна в neurodegenerative-risk context.'],
                'mental-health-risk' => ['status' => 'applicable', 'primary' => true, 'priority' => 10, 'reason' => 'Neuro-resilience важна для stress and cognitive adaptation.'],
                'longevity' => ['status' => 'applicable', 'primary' => false, 'priority' => 15, 'reason' => 'Neuroplastic resilience влияет на long-term healthy aging trajectory.'],
            ],

            'cognitive-recovery-rate' => [
                'general-adult' => ['status' => 'needs_review', 'primary' => false, 'priority' => 97, 'reason' => 'Cognitive recovery требует longitudinal neuroperformance methodology.'],
                'athlete' => ['status' => 'applicable', 'primary' => false, 'priority' => 20, 'reason' => 'Neurocognitive recovery важна в adaptation/performance context.'],
                'chronic-fatigue-risk' => ['status' => 'applicable', 'primary' => true, 'priority' => 10, 'reason' => 'Delayed cognitive recovery связан с fatigue burden context.'],
                'longevity' => ['status' => 'applicable', 'primary' => false, 'priority' => 25, 'reason' => 'Recovery efficiency влияет на cognitive aging trajectory.'],
            ],

            'psychophysiologic-flexibility-score' => [
                'general-adult' => ['status' => 'needs_review', 'primary' => false, 'priority' => 99, 'reason' => 'Psychophysiologic flexibility требует systems-regulation methodology.'],
                'mental-health-risk' => ['status' => 'applicable', 'primary' => true, 'priority' => 10, 'reason' => 'Adaptive psychophysiologic regulation важна для stress resilience.'],
                'longevity' => ['status' => 'applicable', 'primary' => false, 'priority' => 15, 'reason' => 'Regulatory flexibility влияет на resilience and healthy aging.'],
                'athlete' => ['status' => 'applicable', 'primary' => false, 'priority' => 25, 'reason' => 'Stress-adaptation flexibility важна для performance sustainability.'],
            ],

            'social-support-score' => [
                'general-adult' => ['status' => 'needs_review', 'primary' => false, 'priority' => 97, 'reason' => 'Social support modeling требует psychosocial-health methodology.'],
                'mental-health-risk' => ['status' => 'applicable', 'primary' => true, 'priority' => 10, 'reason' => 'Social support является core stress-buffering and resilience domain.'],
                'longevity' => ['status' => 'applicable', 'primary' => false, 'priority' => 15, 'reason' => 'Stable supportive relationships связаны с healthy aging trajectory.'],
            ],

            'loneliness-burden-score' => [
                'general-adult' => ['status' => 'needs_review', 'primary' => false, 'priority' => 98, 'reason' => 'Loneliness burden требует psychosocial longitudinal methodology.'],
                'mental-health-risk' => ['status' => 'applicable', 'primary' => true, 'priority' => 5, 'reason' => 'Loneliness burden связан с stress and mental-health risk context.'],
                'longevity' => ['status' => 'applicable', 'primary' => false, 'priority' => 15, 'reason' => 'Chronic loneliness влияет на resilience and aging trajectory.'],
                'chronic-inflammation-risk' => ['status' => 'applicable', 'primary' => false, 'priority' => 25, 'reason' => 'Social isolation может пересекаться с chronic inflammatory burden.'],
            ],

            'relational-stability-score' => [
                'general-adult' => ['status' => 'needs_review', 'primary' => false, 'priority' => 96, 'reason' => 'Relational stability требует psychosocial-systems methodology.'],
                'mental-health-risk' => ['status' => 'applicable', 'primary' => false, 'priority' => 20, 'reason' => 'Relational instability может усиливать stress burden.'],
                'longevity' => ['status' => 'applicable', 'primary' => true, 'priority' => 15, 'reason' => 'Stable social ecology поддерживает resilience and healthy aging.'],
            ],

            'community-engagement-score' => [
                'general-adult' => ['status' => 'needs_review', 'primary' => false, 'priority' => 95, 'reason' => 'Community engagement требует behavioral-social methodology.'],
                'longevity' => ['status' => 'applicable', 'primary' => true, 'priority' => 10, 'reason' => 'Social participation связана с healthy aging and cognitive resilience.'],
                'senior' => ['status' => 'applicable', 'primary' => false, 'priority' => 20, 'reason' => 'Community integration особенно важна в aging-resilience context.'],
            ],

            'caregiver-burden-score' => [
                'general-adult' => ['status' => 'needs_review', 'primary' => false, 'priority' => 98, 'reason' => 'Caregiver burden требует psychosocial stress-load methodology.'],
                'mental-health-risk' => ['status' => 'applicable', 'primary' => true, 'priority' => 15, 'reason' => 'Caregiver stress может усиливать chronic stress and fatigue burden.'],
                'chronic-fatigue-risk' => ['status' => 'applicable', 'primary' => false, 'priority' => 20, 'reason' => 'Persistent caregiving load может пересекаться с recovery impairment.'],
            ],

            'belonging-resilience-score' => [
                'general-adult' => ['status' => 'needs_review', 'primary' => false, 'priority' => 99, 'reason' => 'Belonging resilience требует psychosocial integration methodology.'],
                'mental-health-risk' => ['status' => 'applicable', 'primary' => true, 'priority' => 10, 'reason' => 'Sense of belonging важен для psychophysiologic resilience.'],
                'longevity' => ['status' => 'applicable', 'primary' => false, 'priority' => 15, 'reason' => 'Social integration влияет на healthy aging trajectory.'],
            ],

            'social-recovery-capacity' => [
                'general-adult' => ['status' => 'needs_review', 'primary' => false, 'priority' => 98, 'reason' => 'Social recovery capacity требует social-regulation methodology.'],
                'mental-health-risk' => ['status' => 'applicable', 'primary' => false, 'priority' => 20, 'reason' => 'Supportive recovery ecology важна для stress-buffering context.'],
                'longevity' => ['status' => 'applicable', 'primary' => true, 'priority' => 10, 'reason' => 'Relational resilience влияет на long-term adaptive capacity.'],
            ],

            'interpersonal-stress-load-score' => [
                'general-adult' => ['status' => 'needs_review', 'primary' => false, 'priority' => 97, 'reason' => 'Interpersonal stress modeling требует psychosocial-load methodology.'],
                'mental-health-risk' => ['status' => 'applicable', 'primary' => true, 'priority' => 10, 'reason' => 'Relational stress burden важен в psychophysiologic regulation context.'],
                'chronic-inflammation-risk' => ['status' => 'applicable', 'primary' => false, 'priority' => 25, 'reason' => 'Chronic psychosocial stress может усиливать inflammatory burden.'],
            ],

            'social-circadian-alignment-score' => [
                'general-adult' => ['status' => 'needs_review', 'primary' => false, 'priority' => 96, 'reason' => 'Social circadian alignment требует behavioral-rhythm methodology.'],
                'longevity' => ['status' => 'applicable', 'primary' => true, 'priority' => 15, 'reason' => 'Stable social rhythms поддерживают circadian resilience and healthy aging.'],
                'mental-health-risk' => ['status' => 'applicable', 'primary' => false, 'priority' => 20, 'reason' => 'Rhythm instability может пересекаться с stress-regulation burden.'],
            ],

            'human-resilience-ecosystem-score' => [
                'general-adult' => ['status' => 'needs_review', 'primary' => false, 'priority' => 99, 'reason' => 'Human resilience ecosystem требует integrated psychosocial-systems methodology.'],
                'longevity' => ['status' => 'applicable', 'primary' => true, 'priority' => 5, 'reason' => 'Human support ecology является частью resilience and healthy aging trajectory.'],
                'mental-health-risk' => ['status' => 'applicable', 'primary' => false, 'priority' => 15, 'reason' => 'Psychosocial buffering capacity влияет на stress resilience.'],
                'chronic-fatigue-risk' => ['status' => 'applicable', 'primary' => false, 'priority' => 25, 'reason' => 'Support-system instability может ухудшать recovery capacity.'],
            ],

            'purpose-alignment-score' => [
                'general-adult' => ['status' => 'needs_review', 'primary' => false, 'priority' => 99, 'reason' => 'Purpose alignment требует psychosocial-existential methodology.'],
                'mental-health-risk' => ['status' => 'applicable', 'primary' => false, 'priority' => 20, 'reason' => 'Low purpose alignment может усиливать stress and depressive burden.'],
                'longevity' => ['status' => 'applicable', 'primary' => true, 'priority' => 10, 'reason' => 'Sense of purpose связан с resilience and healthy aging trajectory.'],
            ],

            'motivational-resilience-score' => [
                'general-adult' => ['status' => 'needs_review', 'primary' => false, 'priority' => 98, 'reason' => 'Motivational resilience требует behavioral-regulation methodology.'],
                'mental-health-risk' => ['status' => 'applicable', 'primary' => true, 'priority' => 15, 'reason' => 'Motivational stability важна для adaptive stress regulation.'],
                'chronic-fatigue-risk' => ['status' => 'applicable', 'primary' => false, 'priority' => 25, 'reason' => 'Motivational depletion может пересекаться с fatigue-recovery impairment.'],
                'longevity' => ['status' => 'applicable', 'primary' => false, 'priority' => 30, 'reason' => 'Behavioral persistence влияет на long-term health trajectory.'],
            ],

            'existential-stress-load-score' => [
                'general-adult' => ['status' => 'needs_review', 'primary' => false, 'priority' => 99, 'reason' => 'Existential stress modeling требует psychophysiologic-existential methodology.'],
                'mental-health-risk' => ['status' => 'applicable', 'primary' => true, 'priority' => 10, 'reason' => 'Existential stress burden может влиять на psychophysiologic resilience.'],
                'chronic-inflammation-risk' => ['status' => 'applicable', 'primary' => false, 'priority' => 30, 'reason' => 'Chronic existential stress может усиливать systemic stress burden.'],
            ],

            'life-structure-stability-score' => [
                'general-adult' => ['status' => 'needs_review', 'primary' => false, 'priority' => 97, 'reason' => 'Life-structure stability требует behavioral-systems methodology.'],
                'mental-health-risk' => ['status' => 'applicable', 'primary' => false, 'priority' => 20, 'reason' => 'Lifestyle instability может усиливать stress dysregulation.'],
                'longevity' => ['status' => 'applicable', 'primary' => true, 'priority' => 15, 'reason' => 'Stable behavioral structure поддерживает resilience and healthy aging.'],
            ],

            'goal-recovery-capacity-score' => [
                'general-adult' => ['status' => 'needs_review', 'primary' => false, 'priority' => 98, 'reason' => 'Goal recovery capacity требует adaptive-behavior methodology.'],
                'mental-health-risk' => ['status' => 'applicable', 'primary' => false, 'priority' => 25, 'reason' => 'Recovery after setbacks важна для psychologic resilience context.'],
                'athlete' => ['status' => 'applicable', 'primary' => true, 'priority' => 15, 'reason' => 'Adaptive recovery after performance setbacks важна для sustainable adaptation.'],
                'longevity' => ['status' => 'applicable', 'primary' => false, 'priority' => 30, 'reason' => 'Adaptive persistence влияет на long-term resilience trajectory.'],
            ],

            'meaning-resilience-score' => [
                'general-adult' => ['status' => 'needs_review', 'primary' => false, 'priority' => 99, 'reason' => 'Meaning resilience требует existential-psychology methodology.'],
                'mental-health-risk' => ['status' => 'applicable', 'primary' => true, 'priority' => 10, 'reason' => 'Meaning stability важна для stress-buffering and emotional resilience.'],
                'longevity' => ['status' => 'applicable', 'primary' => false, 'priority' => 20, 'reason' => 'Purpose-driven resilience может поддерживать healthy aging trajectory.'],
            ],

            'identity-coherence-score' => [
                'general-adult' => ['status' => 'needs_review', 'primary' => false, 'priority' => 99, 'reason' => 'Identity coherence требует psychosocial-developmental methodology.'],
                'mental-health-risk' => ['status' => 'applicable', 'primary' => true, 'priority' => 15, 'reason' => 'Identity stability может влиять на psychophysiologic resilience.'],
            ],

            'future-orientation-score' => [
                'general-adult' => ['status' => 'needs_review', 'primary' => false, 'priority' => 97, 'reason' => 'Future orientation требует behavioral-psychology methodology.'],
                'mental-health-risk' => ['status' => 'applicable', 'primary' => false, 'priority' => 20, 'reason' => 'Loss of future orientation может пересекаться с stress/depressive burden.'],
                'longevity' => ['status' => 'applicable', 'primary' => true, 'priority' => 15, 'reason' => 'Future-oriented behavioral persistence поддерживает long-term health trajectories.'],
            ],

            'adaptive-motivation-flexibility-score' => [
                'general-adult' => ['status' => 'needs_review', 'primary' => false, 'priority' => 99, 'reason' => 'Adaptive motivation flexibility требует systems-behavior methodology.'],
                'mental-health-risk' => ['status' => 'applicable', 'primary' => true, 'priority' => 10, 'reason' => 'Flexible motivational adaptation важна для stress resilience.'],
                'athlete' => ['status' => 'applicable', 'primary' => false, 'priority' => 20, 'reason' => 'Adaptive motivation важна для sustainable performance progression.'],
                'longevity' => ['status' => 'applicable', 'primary' => false, 'priority' => 25, 'reason' => 'Behavioral adaptability влияет на resilience and healthy aging trajectory.'],
            ],

            'human-flourishing-score' => [
                'general-adult' => ['status' => 'needs_review', 'primary' => false, 'priority' => 100, 'reason' => 'Human flourishing требует integrated biopsychosocial systems methodology.'],
                'longevity' => ['status' => 'applicable', 'primary' => true, 'priority' => 5, 'reason' => 'Human flourishing является high-level systems-health and resilience concept.'],
                'mental-health-risk' => ['status' => 'applicable', 'primary' => false, 'priority' => 15, 'reason' => 'Psychological flourishing тесно связано с adaptive resilience capacity.'],
            ],




        ];

        foreach ($matrix as $markerSlug => $applicableProfiles) {

            $marker = Marker::where('slug', $markerSlug)->first();

            if (!$marker) {
                continue;
            }

            foreach ($profiles as $profileSlug => $profile) {

                $config = $applicableProfiles[$profileSlug] ?? null;

                MarkerProfileApplicability::updateOrCreate(
                    [
                        'marker_id' => $marker->id,
                        'scoring_profile_id' => $profile->id,
                    ],
                    [
                        'applicability_status' => $config['status']
                            ?? 'not_applicable',

                        'is_primary' => $config['primary']
                            ?? false,

                        'priority' => $config['priority']
                            ?? 0,

                        'reason' => $config['reason']
                            ?? 'Profile currently not applicable for this marker.',

                        'note' => null,

                        'is_active' => true,
                    ]
                );
            }
        }
    }
}