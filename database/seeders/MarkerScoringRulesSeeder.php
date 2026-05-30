<?php

namespace Database\Seeders;

use App\Models\Marker;
use App\Models\MarkerScoringProfile;
use App\Models\MarkerScoringRule;
use Illuminate\Database\Seeder;

class MarkerScoringRulesSeeder extends Seeder
{
    public function run(): void
    {
        $profile = MarkerScoringProfile::where('slug', 'general-adult')->firstOrFail();

        /*
        |--------------------------------------------------------------------------
        | DSlog scoring rules — General adult profile
        |--------------------------------------------------------------------------
        |
        | This seeder is intentionally conservative.
        |
        | These ranges are NOT diagnosis rules. They are product scoring bands for
        | chart zones, trend visualization and internal completeness checks.
        |
        | Profile-specific rules for male/female/pregnancy/senior/risk profiles
        | should be added separately. General adult is the fallback layer.
        |
        */

        $rules = [

            /*
            |--------------------------------------------------------------------------
            | CBC / anemia / inflammation
            |--------------------------------------------------------------------------
            */

            'hemoglobin' => [
                'direction' => 'range',
                'health_direction' => 'range_is_better',

                'critical_low_max' => 90,
                'needs_control_low_max' => 119,
                'borderline_low_max' => 124,

                'optimal_min' => 125,
                'optimal_max' => 155,

                'exceptional_min' => null,
                'exceptional_max' => null,

                'borderline_high_min' => 156,
                'needs_control_high_min' => 166,
                'critical_high_min' => 181,

                'unit' => 'г/л',
                'display_precision' => 0,
                'source' => 'DSlog MVP scoring; general adult fallback; sex-specific rules should override',
                'note' => 'General adult hemoglobin scoring. Use male/female/pregnancy profiles for stricter interpretation.',
            ],

            'ferritin' => [
                'direction' => 'range',
                'health_direction' => 'range_is_better',

                'critical_low_max' => 10,
                'needs_control_low_max' => 20,
                'borderline_low_max' => 39,

                'optimal_min' => 40,
                'optimal_max' => 120,

                'exceptional_min' => 60,
                'exceptional_max' => 90,

                'borderline_high_min' => 121,
                'needs_control_high_min' => 250,
                'critical_high_min' => 400,

                'unit' => 'нг/мл',
                'display_precision' => 0,
                'source' => 'DSlog MVP scoring; general adult fallback; ferritin is context dependent',
                'note' => 'Ferritin is highly context-dependent. Sex, pregnancy, inflammation and iron-deficiency-risk profiles should override this fallback.',
            ],

            'crp' => [
                'direction' => 'lower_better',
                'health_direction' => 'lower_is_better',

                'critical_low_max' => null,
                'needs_control_low_max' => null,
                'borderline_low_max' => null,

                'optimal_min' => 0,
                'optimal_max' => 1.0,

                'exceptional_min' => 0,
                'exceptional_max' => 0.5,

                'borderline_high_min' => 1.1,
                'needs_control_high_min' => 3.1,
                'critical_high_min' => 10.1,

                'unit' => 'мг/л',
                'display_precision' => 1,
                'source' => 'DSlog MVP scoring; commonly used hs-CRP cardiovascular risk bands',
                'note' => 'Lower is generally better. Acute infection/inflammation context can override preventive-risk interpretation.',
            ],

            /*
            |--------------------------------------------------------------------------
            | Glucose metabolism
            |--------------------------------------------------------------------------
            */

            'glucose' => [
                'direction' => 'range',
                'health_direction' => 'range_is_better',

                'critical_low_max' => 3.0,
                'needs_control_low_max' => 3.5,
                'borderline_low_max' => 3.9,

                'optimal_min' => 4.3,
                'optimal_max' => 5.2,

                'exceptional_min' => 4.5,
                'exceptional_max' => 4.9,

                'borderline_high_min' => 5.3,
                'needs_control_high_min' => 6.1,
                'critical_high_min' => 7.0,

                'unit' => 'ммоль/л',
                'display_precision' => 1,
                'source' => 'ADA/CDC diabetes and prediabetes thresholds; DSlog preventive fallback',
                'note' => 'Assumes fasting plasma glucose. Pregnancy and insulin-resistance profiles should override.',
            ],

            'hba1c' => [
                'direction' => 'lower_better',
                'health_direction' => 'lower_is_better',

                'critical_low_max' => null,
                'needs_control_low_max' => null,
                'borderline_low_max' => null,

                'optimal_min' => 0,
                'optimal_max' => 5.2,

                'exceptional_min' => 0,
                'exceptional_max' => 4.9,

                'borderline_high_min' => 5.3,
                'needs_control_high_min' => 5.7,
                'critical_high_min' => 6.5,

                'unit' => '%',
                'display_precision' => 1,
                'source' => 'ADA/CDC diabetes and prediabetes thresholds; DSlog preventive fallback',
                'note' => 'Lower is generally better until clinical lower-bound context is known. Diabetes diagnosis requires clinical confirmation.',
            ],

            /*
            |--------------------------------------------------------------------------
            | Lipids / cardiovascular
            |--------------------------------------------------------------------------
            */

            'total-cholesterol' => [
                'direction' => 'lower_better',
                'health_direction' => 'lower_is_better',

                'critical_low_max' => null,
                'needs_control_low_max' => null,
                'borderline_low_max' => null,

                'optimal_min' => 0,
                'optimal_max' => 5.1,

                'exceptional_min' => 0,
                'exceptional_max' => 4.5,

                'borderline_high_min' => 5.2,
                'needs_control_high_min' => 6.2,
                'critical_high_min' => 7.5,

                'unit' => 'ммоль/л',
                'display_precision' => 1,
                'source' => 'MedlinePlus/Cleveland Clinic cholesterol categories converted to mmol/L',
                'note' => 'Total cholesterol is a rough marker. LDL, HDL, triglycerides and risk profile are more informative.',
            ],

            'ldl' => [
                'direction' => 'lower_better',
                'health_direction' => 'lower_is_better',

                'critical_low_max' => null,
                'needs_control_low_max' => null,
                'borderline_low_max' => null,

                'optimal_min' => 0,
                'optimal_max' => 2.6,

                'exceptional_min' => 0,
                'exceptional_max' => 1.8,

                'borderline_high_min' => 2.7,
                'needs_control_high_min' => 3.4,
                'critical_high_min' => 4.9,

                'unit' => 'ммоль/л',
                'display_precision' => 1,
                'source' => 'Common LDL cholesterol categories converted to mmol/L; DSlog cardiovascular fallback',
                'note' => 'LDL goals are risk-dependent. Cardiovascular-risk profile should override with stricter targets.',
            ],

            'hdl' => [
                'direction' => 'higher_better',
                'health_direction' => 'higher_is_better',

                'critical_low_max' => 0.7,
                'needs_control_low_max' => 0.99,
                'borderline_low_max' => 1.19,

                'optimal_min' => 1.2,
                'optimal_max' => 1.89,

                'exceptional_min' => 1.9,
                'exceptional_max' => 3.0,

                'borderline_high_min' => null,
                'needs_control_high_min' => null,
                'critical_high_min' => null,

                'unit' => 'ммоль/л',
                'display_precision' => 1,
                'source' => 'MedlinePlus/Cleveland Clinic HDL categories converted to mmol/L; DSlog fallback',
                'note' => 'Higher HDL is generally favorable, but HDL should not be interpreted alone.',
            ],

            'triglycerides' => [
                'direction' => 'lower_better',
                'health_direction' => 'lower_is_better',

                'critical_low_max' => null,
                'needs_control_low_max' => null,
                'borderline_low_max' => null,

                'optimal_min' => 0,
                'optimal_max' => 1.5,

                'exceptional_min' => 0,
                'exceptional_max' => 1.0,

                'borderline_high_min' => 1.7,
                'needs_control_high_min' => 2.3,
                'critical_high_min' => 5.7,

                'unit' => 'ммоль/л',
                'display_precision' => 1,
                'source' => 'Mayo Clinic / Cleveland Clinic triglyceride categories converted to mmol/L',
                'note' => 'Very high triglycerides may require clinical attention. Fasting status matters.',
            ],

            /*
            |--------------------------------------------------------------------------
            | Liver enzymes
            |--------------------------------------------------------------------------
            */

            'alt' => [
                'direction' => 'lower_better',
                'health_direction' => 'lower_is_better',

                'critical_low_max' => null,
                'needs_control_low_max' => null,
                'borderline_low_max' => null,

                'optimal_min' => 4,
                'optimal_max' => 30,

                'exceptional_min' => 8,
                'exceptional_max' => 24,

                'borderline_high_min' => 31,
                'needs_control_high_min' => 45,
                'critical_high_min' => 150,

                'unit' => 'Ед/л',
                'display_precision' => 0,
                'source' => 'MedlinePlus ALT normal range 4-36 U/L; DSlog preventive fallback',
                'note' => 'ALT is interpreted with AST, GGT, bilirubin and clinical context. Critical band is a DSlog attention threshold, not a diagnosis.',
            ],

            'ast' => [
                'direction' => 'lower_better',
                'health_direction' => 'lower_is_better',

                'critical_low_max' => null,
                'needs_control_low_max' => null,
                'borderline_low_max' => null,

                'optimal_min' => 8,
                'optimal_max' => 30,

                'exceptional_min' => 10,
                'exceptional_max' => 24,

                'borderline_high_min' => 34,
                'needs_control_high_min' => 45,
                'critical_high_min' => 150,

                'unit' => 'Ед/л',
                'display_precision' => 0,
                'source' => 'MedlinePlus AST normal range 8-33 U/L; DSlog preventive fallback',
                'note' => 'AST is less liver-specific than ALT and can rise with muscle injury. Interpret with ALT and context.',
            ],

            'ggt' => [
                'direction' => 'lower_better',
                'health_direction' => 'lower_is_better',

                'critical_low_max' => null,
                'needs_control_low_max' => null,
                'borderline_low_max' => null,

                'optimal_min' => 5,
                'optimal_max' => 35,

                'exceptional_min' => 8,
                'exceptional_max' => 25,

                'borderline_high_min' => 41,
                'needs_control_high_min' => 80,
                'critical_high_min' => 200,

                'unit' => 'Ед/л',
                'display_precision' => 0,
                'source' => 'MedlinePlus GGT adult range 5-40 U/L; DSlog preventive fallback',
                'note' => 'GGT is interpreted with liver panel, alcohol/medication context and bile duct markers.',
            ],

            /*
            |--------------------------------------------------------------------------
            | Kidney function
            |--------------------------------------------------------------------------
            */

            'creatinine' => [
                'direction' => 'range',
                'health_direction' => 'range_is_better',

                'critical_low_max' => null,
                'needs_control_low_max' => null,
                'borderline_low_max' => 44,

                'optimal_min' => 55,
                'optimal_max' => 95,

                'exceptional_min' => 60,
                'exceptional_max' => 85,

                'borderline_high_min' => 96,
                'needs_control_high_min' => 111,
                'critical_high_min' => 150,

                'unit' => 'мкмоль/л',
                'display_precision' => 0,
                'source' => 'Mayo Clinic adult creatinine ranges; DSlog broad general-adult fallback',
                'note' => 'Creatinine is strongly affected by sex, age and muscle mass. Prefer eGFR and profile-specific rules.',
            ],

            'egfr' => [
                'direction' => 'higher_better',
                'health_direction' => 'higher_is_better',

                'critical_low_max' => 15,
                'needs_control_low_max' => 59,
                'borderline_low_max' => 89,

                'optimal_min' => 90,
                'optimal_max' => 120,

                'exceptional_min' => 100,
                'exceptional_max' => 120,

                'borderline_high_min' => null,
                'needs_control_high_min' => null,
                'critical_high_min' => null,

                'unit' => 'мл/мин/1.73м²',
                'display_precision' => 0,
                'source' => 'National Kidney Foundation eGFR categories; DSlog fallback',
                'note' => 'eGFR interpretation depends on age, albuminuria and chronicity. A single value is not CKD diagnosis.',
            ],

            /*
            |--------------------------------------------------------------------------
            | Vitamins
            |--------------------------------------------------------------------------
            */

            'vitamin-d' => [
                'direction' => 'range',
                'health_direction' => 'range_is_better',

                'critical_low_max' => 10,
                'needs_control_low_max' => 20,
                'borderline_low_max' => 30,

                'optimal_min' => 40,
                'optimal_max' => 70,

                'exceptional_min' => 50,
                'exceptional_max' => 60,

                'borderline_high_min' => 71,
                'needs_control_high_min' => 100,
                'critical_high_min' => 150,

                'unit' => 'нг/мл',
                'display_precision' => 0,
                'source' => 'DSlog MVP scoring; vitamin D thresholds vary by guideline',
                'note' => 'Vitamin D interpretation varies by guideline, supplementation and clinical context.',
            ],

            'vitamin-b12' => [
                'direction' => 'range',
                'health_direction' => 'range_is_better',

                'critical_low_max' => 150,
                'needs_control_low_max' => 250,
                'borderline_low_max' => 399,

                'optimal_min' => 400,
                'optimal_max' => 900,

                'exceptional_min' => 500,
                'exceptional_max' => 800,

                'borderline_high_min' => 951,
                'needs_control_high_min' => 1500,
                'critical_high_min' => 2000,

                'unit' => 'пг/мл',
                'display_precision' => 0,
                'source' => 'NIH ODS / MedlinePlus B12 status ranges; DSlog fallback',
                'note' => 'Borderline B12 may require MMA/homocysteine confirmation. High B12 is context-dependent and often supplementation-related.',
            ],

            'folate' => [
                'direction' => 'range',
                'health_direction' => 'range_is_better',

                'critical_low_max' => 2.0,
                'needs_control_low_max' => 3.0,
                'borderline_low_max' => 4.0,

                'optimal_min' => 6.0,
                'optimal_max' => 17.0,

                'exceptional_min' => 8.0,
                'exceptional_max' => 15.0,

                'borderline_high_min' => 17.1,
                'needs_control_high_min' => 25.0,
                'critical_high_min' => 40.0,

                'unit' => 'нг/мл',
                'display_precision' => 1,
                'source' => 'MedlinePlus folate range 2.7-17 ng/mL; StatPearls deficiency bands; DSlog fallback',
                'note' => 'Serum folate is affected by recent intake. RBC folate may be more stable for tissue stores.',
            ],

            /*
            |--------------------------------------------------------------------------
            | Thyroid
            |--------------------------------------------------------------------------
            */

            'tsh' => [
                'direction' => 'range',
                'health_direction' => 'range_is_better',

                'critical_low_max' => 0.1,
                'needs_control_low_max' => 0.3,
                'borderline_low_max' => 0.5,

                'optimal_min' => 0.8,
                'optimal_max' => 2.5,

                'exceptional_min' => 1.0,
                'exceptional_max' => 2.0,

                'borderline_high_min' => 2.6,
                'needs_control_high_min' => 4.0,
                'critical_high_min' => 10.0,

                'unit' => 'мЕд/л',
                'display_precision' => 1,
                'source' => 'DSlog MVP scoring; general adult thyroid fallback',
                'note' => 'TSH interpretation depends on pregnancy, age, thyroid medication and free T4/free T3.',
            ],

            /*
            |--------------------------------------------------------------------------
            | MarkerScoringRulesSeeder — general-adult missing rules quality pack v2
            |--------------------------------------------------------------------------
            | Paste the array entries below inside the existing $rules = [ ... ]; array.
            | This pack intentionally covers only numeric, reasonably high-confidence
            | general-adult fallback rules. Do not use it for diagnosis; lab ranges and
            | user profile specific rules should override it where available.
            */

            'wbc' => [
                'direction' => 'range',
                'critical_low_max' => 2.0,
                'needs_control_low_max' => 3.4,
                'borderline_low_max' => 3.9,
                'optimal_min' => 4.0,
                'optimal_max' => 10.0,
                'exceptional_min' => null,
                'exceptional_max' => null,
                'borderline_high_min' => 10.1,
                'needs_control_high_min' => 12.1,
                'critical_high_min' => 25.0,
                'unit' => '10^9/л',
                'zone_mode' => 'bands',
                'health_direction' => 'range_is_better',
                'display_precision' => 1,
                'source' => 'DSlog general-adult fallback scoring; lab-specific reference intervals and clinical context must override',
                'note' => 'General adult WBC fallback. Differential and symptoms matter.',
            ],

            'rbc' => [
                'direction' => 'range',
                'critical_low_max' => 3.0,
                'needs_control_low_max' => 3.7,
                'borderline_low_max' => 3.99,
                'optimal_min' => 4.0,
                'optimal_max' => 5.5,
                'exceptional_min' => null,
                'exceptional_max' => null,
                'borderline_high_min' => 5.6,
                'needs_control_high_min' => 6.1,
                'critical_high_min' => 7.0,
                'unit' => '10^12/л',
                'zone_mode' => 'bands',
                'health_direction' => 'range_is_better',
                'display_precision' => 2,
                'source' => 'DSlog general-adult fallback scoring; lab-specific reference intervals and clinical context must override',
                'note' => 'Broad general adult RBC fallback; sex-specific rules should override.',
            ],

            'hematocrit' => [
                'direction' => 'range',
                'critical_low_max' => 0.28,
                'needs_control_low_max' => 0.34,
                'borderline_low_max' => 0.35,
                'optimal_min' => 0.36,
                'optimal_max' => 0.5,
                'exceptional_min' => null,
                'exceptional_max' => null,
                'borderline_high_min' => 0.51,
                'needs_control_high_min' => 0.55,
                'critical_high_min' => 0.6,
                'unit' => 'л/л',
                'zone_mode' => 'bands',
                'health_direction' => 'range_is_better',
                'display_precision' => 2,
                'source' => 'DSlog general-adult fallback scoring; lab-specific reference intervals and clinical context must override',
                'note' => 'Broad adult hematocrit fallback; male/female profiles should override.',
            ],

            'mcv' => [
                'direction' => 'range',
                'critical_low_max' => 65,
                'needs_control_low_max' => 74,
                'borderline_low_max' => 79,
                'optimal_min' => 80,
                'optimal_max' => 96,
                'exceptional_min' => null,
                'exceptional_max' => null,
                'borderline_high_min' => 97,
                'needs_control_high_min' => 101,
                'critical_high_min' => 115,
                'unit' => 'фл',
                'zone_mode' => 'bands',
                'health_direction' => 'range_is_better',
                'display_precision' => 0,
                'source' => 'DSlog general-adult fallback scoring; lab-specific reference intervals and clinical context must override',
                'note' => 'MCV fallback: interpret with Hb, ferritin, B12 and folate.',
            ],

            'mch' => [
                'direction' => 'range',
                'critical_low_max' => 22,
                'needs_control_low_max' => 25,
                'borderline_low_max' => 26,
                'optimal_min' => 27,
                'optimal_max' => 33,
                'exceptional_min' => null,
                'exceptional_max' => null,
                'borderline_high_min' => 34,
                'needs_control_high_min' => 36,
                'critical_high_min' => 40,
                'unit' => 'пг',
                'zone_mode' => 'bands',
                'health_direction' => 'range_is_better',
                'display_precision' => 1,
                'source' => 'DSlog general-adult fallback scoring; lab-specific reference intervals and clinical context must override',
                'note' => 'MCH fallback; interpret with MCV/MCHC and anemia markers.',
            ],

            'mchc' => [
                'direction' => 'range',
                'critical_low_max' => 280,
                'needs_control_low_max' => 309,
                'borderline_low_max' => 319,
                'optimal_min' => 320,
                'optimal_max' => 360,
                'exceptional_min' => null,
                'exceptional_max' => null,
                'borderline_high_min' => 361,
                'needs_control_high_min' => 371,
                'critical_high_min' => 390,
                'unit' => 'г/л',
                'zone_mode' => 'bands',
                'health_direction' => 'range_is_better',
                'display_precision' => 0,
                'source' => 'DSlog general-adult fallback scoring; lab-specific reference intervals and clinical context must override',
                'note' => 'MCHC fallback; high values may reflect hemolysis/spherocytosis or artifact.',
            ],

            'rdw' => [
                'direction' => 'lower_better',
                'critical_low_max' => null,
                'needs_control_low_max' => null,
                'borderline_low_max' => null,
                'optimal_min' => 0,
                'optimal_max' => 14.5,
                'exceptional_min' => 0,
                'exceptional_max' => 13.5,
                'borderline_high_min' => 14.6,
                'needs_control_high_min' => 16.0,
                'critical_high_min' => 20.0,
                'unit' => '%',
                'zone_mode' => 'bands',
                'health_direction' => 'lower_is_better',
                'display_precision' => 1,
                'source' => 'DSlog general-adult fallback scoring; lab-specific reference intervals and clinical context must override',
                'note' => 'RDW high suggests anisocytosis; interpret with MCV, Hb, iron/B12/folate.',
            ],

            'platelets' => [
                'direction' => 'range',
                'critical_low_max' => 50,
                'needs_control_low_max' => 100,
                'borderline_low_max' => 149,
                'optimal_min' => 150,
                'optimal_max' => 400,
                'exceptional_min' => null,
                'exceptional_max' => null,
                'borderline_high_min' => 401,
                'needs_control_high_min' => 450,
                'critical_high_min' => 1000,
                'unit' => '10^9/л',
                'zone_mode' => 'bands',
                'health_direction' => 'range_is_better',
                'display_precision' => 0,
                'source' => 'DSlog general-adult fallback scoring; lab-specific reference intervals and clinical context must override',
                'note' => 'Platelet count fallback; symptoms and trend matter.',
            ],

            'neutrophils' => [
                'direction' => 'range',
                'critical_low_max' => 0.5,
                'needs_control_low_max' => 1.0,
                'borderline_low_max' => 1.79,
                'optimal_min' => 1.8,
                'optimal_max' => 7.5,
                'exceptional_min' => null,
                'exceptional_max' => null,
                'borderline_high_min' => 7.6,
                'needs_control_high_min' => 10.0,
                'critical_high_min' => 20.0,
                'unit' => '10^9/л',
                'zone_mode' => 'bands',
                'health_direction' => 'range_is_better',
                'display_precision' => 1,
                'source' => 'DSlog general-adult fallback scoring; lab-specific reference intervals and clinical context must override',
                'note' => 'Absolute neutrophil count fallback.',
            ],

            'lymphocytes' => [
                'direction' => 'range',
                'critical_low_max' => 0.5,
                'needs_control_low_max' => 0.8,
                'borderline_low_max' => 0.99,
                'optimal_min' => 1.0,
                'optimal_max' => 4.0,
                'exceptional_min' => null,
                'exceptional_max' => null,
                'borderline_high_min' => 4.1,
                'needs_control_high_min' => 5.0,
                'critical_high_min' => 10.0,
                'unit' => '10^9/л',
                'zone_mode' => 'bands',
                'health_direction' => 'range_is_better',
                'display_precision' => 1,
                'source' => 'DSlog general-adult fallback scoring; lab-specific reference intervals and clinical context must override',
                'note' => 'Absolute lymphocyte count fallback.',
            ],

            'monocytes' => [
                'direction' => 'range',
                'critical_low_max' => null,
                'needs_control_low_max' => null,
                'borderline_low_max' => 0.19,
                'optimal_min' => 0.2,
                'optimal_max' => 0.8,
                'exceptional_min' => null,
                'exceptional_max' => null,
                'borderline_high_min' => 0.81,
                'needs_control_high_min' => 1.0,
                'critical_high_min' => 2.0,
                'unit' => '10^9/л',
                'zone_mode' => 'bands',
                'health_direction' => 'range_is_better',
                'display_precision' => 2,
                'source' => 'DSlog general-adult fallback scoring; lab-specific reference intervals and clinical context must override',
                'note' => 'Absolute monocyte count fallback.',
            ],

            'eosinophils' => [
                'direction' => 'lower_better',
                'critical_low_max' => null,
                'needs_control_low_max' => null,
                'borderline_low_max' => null,
                'optimal_min' => 0,
                'optimal_max' => 0.5,
                'exceptional_min' => 0,
                'exceptional_max' => 0.3,
                'borderline_high_min' => 0.51,
                'needs_control_high_min' => 1.5,
                'critical_high_min' => 5.0,
                'unit' => '10^9/л',
                'zone_mode' => 'bands',
                'health_direction' => 'lower_is_better',
                'display_precision' => 2,
                'source' => 'DSlog general-adult fallback scoring; lab-specific reference intervals and clinical context must override',
                'note' => 'Eosinophilia needs context: allergy, parasites, drugs and immune disease.',
            ],

            'basophils' => [
                'direction' => 'lower_better',
                'critical_low_max' => null,
                'needs_control_low_max' => null,
                'borderline_low_max' => null,
                'optimal_min' => 0,
                'optimal_max' => 0.1,
                'exceptional_min' => 0,
                'exceptional_max' => 0.05,
                'borderline_high_min' => 0.11,
                'needs_control_high_min' => 0.2,
                'critical_high_min' => 1.0,
                'unit' => '10^9/л',
                'zone_mode' => 'bands',
                'health_direction' => 'lower_is_better',
                'display_precision' => 2,
                'source' => 'DSlog general-adult fallback scoring; lab-specific reference intervals and clinical context must override',
                'note' => 'Basophils are usually low; persistent elevation needs context.',
            ],

            'esr' => [
                'direction' => 'lower_better',
                'critical_low_max' => null,
                'needs_control_low_max' => null,
                'borderline_low_max' => null,
                'optimal_min' => 0,
                'optimal_max' => 15,
                'exceptional_min' => 0,
                'exceptional_max' => 10,
                'borderline_high_min' => 16,
                'needs_control_high_min' => 30,
                'critical_high_min' => 60,
                'unit' => 'мм/ч',
                'zone_mode' => 'bands',
                'health_direction' => 'lower_is_better',
                'display_precision' => 0,
                'source' => 'DSlog general-adult fallback scoring; lab-specific reference intervals and clinical context must override',
                'note' => 'ESR is age/sex dependent; this is broad adult fallback.',
            ],

            'reticulocytes' => [
                'direction' => 'range',
                'critical_low_max' => 0.2,
                'needs_control_low_max' => 0.4,
                'borderline_low_max' => 0.49,
                'optimal_min' => 0.5,
                'optimal_max' => 2.5,
                'exceptional_min' => null,
                'exceptional_max' => null,
                'borderline_high_min' => 2.6,
                'needs_control_high_min' => 4.0,
                'critical_high_min' => 8.0,
                'unit' => '%',
                'zone_mode' => 'bands',
                'health_direction' => 'range_is_better',
                'display_precision' => 1,
                'source' => 'DSlog general-adult fallback scoring; lab-specific reference intervals and clinical context must override',
                'note' => 'Reticulocytes should be interpreted with anemia/hemolysis context.',
            ],

            'mpv' => [
                'direction' => 'range',
                'critical_low_max' => 6.0,
                'needs_control_low_max' => 7.0,
                'borderline_low_max' => 7.4,
                'optimal_min' => 7.5,
                'optimal_max' => 11.5,
                'exceptional_min' => null,
                'exceptional_max' => null,
                'borderline_high_min' => 11.6,
                'needs_control_high_min' => 13.0,
                'critical_high_min' => 15.0,
                'unit' => 'фл',
                'zone_mode' => 'bands',
                'health_direction' => 'range_is_better',
                'display_precision' => 1,
                'source' => 'DSlog general-adult fallback scoring; lab-specific reference intervals and clinical context must override',
                'note' => 'MPV is analyzer-dependent; use as supportive marker only.',
            ],

            'urea' => [
                'direction' => 'range',
                'critical_low_max' => null,
                'needs_control_low_max' => 2.0,
                'borderline_low_max' => 2.4,
                'optimal_min' => 2.5,
                'optimal_max' => 8.3,
                'exceptional_min' => null,
                'exceptional_max' => null,
                'borderline_high_min' => 8.4,
                'needs_control_high_min' => 10.0,
                'critical_high_min' => 25.0,
                'unit' => 'ммоль/л',
                'zone_mode' => 'bands',
                'health_direction' => 'range_is_better',
                'display_precision' => 1,
                'source' => 'DSlog general-adult fallback scoring; lab-specific reference intervals and clinical context must override',
                'note' => 'Urea depends on protein intake, hydration, liver and kidney function.',
            ],

            'uric-acid' => [
                'direction' => 'range',
                'critical_low_max' => null,
                'needs_control_low_max' => 150,
                'borderline_low_max' => 179,
                'optimal_min' => 180,
                'optimal_max' => 420,
                'exceptional_min' => null,
                'exceptional_max' => null,
                'borderline_high_min' => 421,
                'needs_control_high_min' => 480,
                'critical_high_min' => 700,
                'unit' => 'мкмоль/л',
                'zone_mode' => 'bands',
                'health_direction' => 'range_is_better',
                'display_precision' => 0,
                'source' => 'DSlog general-adult fallback scoring; lab-specific reference intervals and clinical context must override',
                'note' => 'Uric acid is sex-dependent; broad adult fallback.',
            ],

            'cystatin-c' => [
                'direction' => 'lower_better',
                'critical_low_max' => null,
                'needs_control_low_max' => null,
                'borderline_low_max' => null,
                'optimal_min' => 0.5,
                'optimal_max' => 1.0,
                'exceptional_min' => 0.5,
                'exceptional_max' => 0.9,
                'borderline_high_min' => 1.01,
                'needs_control_high_min' => 1.3,
                'critical_high_min' => 2.0,
                'unit' => 'мг/л',
                'zone_mode' => 'bands',
                'health_direction' => 'lower_is_better',
                'display_precision' => 2,
                'source' => 'DSlog general-adult fallback scoring; lab-specific reference intervals and clinical context must override',
                'note' => 'Cystatin C interpretation depends on eGFR equation and clinical context.',
            ],

            'sodium' => [
                'direction' => 'range',
                'critical_low_max' => 125,
                'needs_control_low_max' => 134,
                'borderline_low_max' => 134.9,
                'optimal_min' => 135,
                'optimal_max' => 145,
                'exceptional_min' => null,
                'exceptional_max' => null,
                'borderline_high_min' => 145.1,
                'needs_control_high_min' => 150,
                'critical_high_min' => 160,
                'unit' => 'ммоль/л',
                'zone_mode' => 'bands',
                'health_direction' => 'range_is_better',
                'display_precision' => 0,
                'source' => 'DSlog general-adult fallback scoring; lab-specific reference intervals and clinical context must override',
                'note' => 'Sodium disorders can be clinically important; trend and symptoms matter.',
            ],

            'potassium' => [
                'direction' => 'range',
                'critical_low_max' => 2.8,
                'needs_control_low_max' => 3.4,
                'borderline_low_max' => 3.49,
                'optimal_min' => 3.5,
                'optimal_max' => 5.1,
                'exceptional_min' => null,
                'exceptional_max' => null,
                'borderline_high_min' => 5.2,
                'needs_control_high_min' => 5.5,
                'critical_high_min' => 6.5,
                'unit' => 'ммоль/л',
                'zone_mode' => 'bands',
                'health_direction' => 'range_is_better',
                'display_precision' => 1,
                'source' => 'DSlog general-adult fallback scoring; lab-specific reference intervals and clinical context must override',
                'note' => 'Potassium abnormalities can be urgent; check hemolysis and medications.',
            ],

            'chloride' => [
                'direction' => 'range',
                'critical_low_max' => 85,
                'needs_control_low_max' => 94,
                'borderline_low_max' => 97,
                'optimal_min' => 98,
                'optimal_max' => 107,
                'exceptional_min' => null,
                'exceptional_max' => null,
                'borderline_high_min' => 108,
                'needs_control_high_min' => 112,
                'critical_high_min' => 125,
                'unit' => 'ммоль/л',
                'zone_mode' => 'bands',
                'health_direction' => 'range_is_better',
                'display_precision' => 0,
                'source' => 'DSlog general-adult fallback scoring; lab-specific reference intervals and clinical context must override',
                'note' => 'Chloride should be interpreted with sodium, bicarbonate and acid-base status.',
            ],

            'bicarbonate' => [
                'direction' => 'range',
                'critical_low_max' => 12,
                'needs_control_low_max' => 18,
                'borderline_low_max' => 21,
                'optimal_min' => 22,
                'optimal_max' => 29,
                'exceptional_min' => null,
                'exceptional_max' => null,
                'borderline_high_min' => 30,
                'needs_control_high_min' => 34,
                'critical_high_min' => 40,
                'unit' => 'ммоль/л',
                'zone_mode' => 'bands',
                'health_direction' => 'range_is_better',
                'display_precision' => 0,
                'source' => 'DSlog general-adult fallback scoring; lab-specific reference intervals and clinical context must override',
                'note' => 'Bicarbonate/CO2 reflects acid-base context; use with anion gap.',
            ],

            'anion-gap' => [
                'direction' => 'range',
                'critical_low_max' => null,
                'needs_control_low_max' => 5,
                'borderline_low_max' => 7,
                'optimal_min' => 8,
                'optimal_max' => 16,
                'exceptional_min' => null,
                'exceptional_max' => null,
                'borderline_high_min' => 17,
                'needs_control_high_min' => 20,
                'critical_high_min' => 30,
                'unit' => 'ммоль/л',
                'zone_mode' => 'bands',
                'health_direction' => 'range_is_better',
                'display_precision' => 0,
                'source' => 'DSlog general-adult fallback scoring; lab-specific reference intervals and clinical context must override',
                'note' => 'Anion gap depends on lab method and albumin; broad fallback.',
            ],

            'calcium' => [
                'direction' => 'range',
                'critical_low_max' => 1.75,
                'needs_control_low_max' => 2.0,
                'borderline_low_max' => 2.14,
                'optimal_min' => 2.15,
                'optimal_max' => 2.55,
                'exceptional_min' => null,
                'exceptional_max' => null,
                'borderline_high_min' => 2.56,
                'needs_control_high_min' => 2.75,
                'critical_high_min' => 3.2,
                'unit' => 'ммоль/л',
                'zone_mode' => 'bands',
                'health_direction' => 'range_is_better',
                'display_precision' => 2,
                'source' => 'DSlog general-adult fallback scoring; lab-specific reference intervals and clinical context must override',
                'note' => 'Total calcium depends on albumin; consider corrected or ionized calcium.',
            ],

            'calcium-ionized' => [
                'direction' => 'range',
                'critical_low_max' => 0.9,
                'needs_control_low_max' => 1.05,
                'borderline_low_max' => 1.11,
                'optimal_min' => 1.12,
                'optimal_max' => 1.32,
                'exceptional_min' => null,
                'exceptional_max' => null,
                'borderline_high_min' => 1.33,
                'needs_control_high_min' => 1.4,
                'critical_high_min' => 1.6,
                'unit' => 'ммоль/л',
                'zone_mode' => 'bands',
                'health_direction' => 'range_is_better',
                'display_precision' => 2,
                'source' => 'DSlog general-adult fallback scoring; lab-specific reference intervals and clinical context must override',
                'note' => 'Ionized calcium is pH/sample dependent.',
            ],

            'magnesium' => [
                'direction' => 'range',
                'critical_low_max' => 0.4,
                'needs_control_low_max' => 0.6,
                'borderline_low_max' => 0.65,
                'optimal_min' => 0.66,
                'optimal_max' => 1.07,
                'exceptional_min' => null,
                'exceptional_max' => null,
                'borderline_high_min' => 1.08,
                'needs_control_high_min' => 1.3,
                'critical_high_min' => 2.0,
                'unit' => 'ммоль/л',
                'zone_mode' => 'bands',
                'health_direction' => 'range_is_better',
                'display_precision' => 2,
                'source' => 'DSlog general-adult fallback scoring; lab-specific reference intervals and clinical context must override',
                'note' => 'Magnesium interpretation depends on kidney function and medications.',
            ],

            'phosphorus' => [
                'direction' => 'range',
                'critical_low_max' => 0.4,
                'needs_control_low_max' => 0.7,
                'borderline_low_max' => 0.8,
                'optimal_min' => 0.81,
                'optimal_max' => 1.45,
                'exceptional_min' => null,
                'exceptional_max' => null,
                'borderline_high_min' => 1.46,
                'needs_control_high_min' => 1.8,
                'critical_high_min' => 2.5,
                'unit' => 'ммоль/л',
                'zone_mode' => 'bands',
                'health_direction' => 'range_is_better',
                'display_precision' => 2,
                'source' => 'DSlog general-adult fallback scoring; lab-specific reference intervals and clinical context must override',
                'note' => 'Phosphate depends on kidney function, vitamin D/PTH and diet.',
            ],

            'osmolality' => [
                'direction' => 'range',
                'critical_low_max' => 250,
                'needs_control_low_max' => 270,
                'borderline_low_max' => 274,
                'optimal_min' => 275,
                'optimal_max' => 295,
                'exceptional_min' => null,
                'exceptional_max' => null,
                'borderline_high_min' => 296,
                'needs_control_high_min' => 305,
                'critical_high_min' => 330,
                'unit' => 'мОсм/кг',
                'zone_mode' => 'bands',
                'health_direction' => 'range_is_better',
                'display_precision' => 0,
                'source' => 'DSlog general-adult fallback scoring; lab-specific reference intervals and clinical context must override',
                'note' => 'Serum osmolality depends on sodium, glucose, urea and toxins.',
            ],

            'albumin' => [
                'direction' => 'range',
                'critical_low_max' => 25,
                'needs_control_low_max' => 34,
                'borderline_low_max' => 34.9,
                'optimal_min' => 35,
                'optimal_max' => 50,
                'exceptional_min' => null,
                'exceptional_max' => null,
                'borderline_high_min' => 51,
                'needs_control_high_min' => 55,
                'critical_high_min' => 60,
                'unit' => 'г/л',
                'zone_mode' => 'bands',
                'health_direction' => 'range_is_better',
                'display_precision' => 0,
                'source' => 'DSlog general-adult fallback scoring; lab-specific reference intervals and clinical context must override',
                'note' => 'Albumin depends on inflammation, liver, kidney loss, nutrition and hydration.',
            ],

            'total-protein' => [
                'direction' => 'range',
                'critical_low_max' => 45,
                'needs_control_low_max' => 59,
                'borderline_low_max' => 63,
                'optimal_min' => 64,
                'optimal_max' => 83,
                'exceptional_min' => null,
                'exceptional_max' => null,
                'borderline_high_min' => 84,
                'needs_control_high_min' => 90,
                'critical_high_min' => 100,
                'unit' => 'г/л',
                'zone_mode' => 'bands',
                'health_direction' => 'range_is_better',
                'display_precision' => 0,
                'source' => 'DSlog general-adult fallback scoring; lab-specific reference intervals and clinical context must override',
                'note' => 'Total protein should be interpreted with albumin/globulin and hydration.',
            ],

            'globulin' => [
                'direction' => 'range',
                'critical_low_max' => 15,
                'needs_control_low_max' => 19,
                'borderline_low_max' => 20,
                'optimal_min' => 21,
                'optimal_max' => 35,
                'exceptional_min' => null,
                'exceptional_max' => null,
                'borderline_high_min' => 36,
                'needs_control_high_min' => 40,
                'critical_high_min' => 50,
                'unit' => 'г/л',
                'zone_mode' => 'bands',
                'health_direction' => 'range_is_better',
                'display_precision' => 0,
                'source' => 'DSlog general-adult fallback scoring; lab-specific reference intervals and clinical context must override',
                'note' => 'Globulin is calculated/indirect in many labs; interpret with total protein and albumin.',
            ],

            'albumin-globulin-ratio' => [
                'direction' => 'range',
                'critical_low_max' => 0.6,
                'needs_control_low_max' => 0.9,
                'borderline_low_max' => 1.0,
                'optimal_min' => 1.1,
                'optimal_max' => 2.2,
                'exceptional_min' => null,
                'exceptional_max' => null,
                'borderline_high_min' => 2.3,
                'needs_control_high_min' => 2.6,
                'critical_high_min' => 3.0,
                'unit' => '',
                'zone_mode' => 'bands',
                'health_direction' => 'range_is_better',
                'display_precision' => 2,
                'source' => 'DSlog general-adult fallback scoring; lab-specific reference intervals and clinical context must override',
                'note' => 'A/G ratio is supportive and depends on albumin and globulin.',
            ],

            'alp' => [
                'direction' => 'range',
                'critical_low_max' => null,
                'needs_control_low_max' => 30,
                'borderline_low_max' => 39,
                'optimal_min' => 40,
                'optimal_max' => 130,
                'exceptional_min' => null,
                'exceptional_max' => null,
                'borderline_high_min' => 131,
                'needs_control_high_min' => 180,
                'critical_high_min' => 500,
                'unit' => 'Ед/л',
                'zone_mode' => 'bands',
                'health_direction' => 'range_is_better',
                'display_precision' => 0,
                'source' => 'DSlog general-adult fallback scoring; lab-specific reference intervals and clinical context must override',
                'note' => 'ALP is age/sex/lab dependent; evaluate with GGT, bilirubin and bone context.',
            ],

            'bilirubin-total' => [
                'direction' => 'lower_better',
                'critical_low_max' => null,
                'needs_control_low_max' => null,
                'borderline_low_max' => null,
                'optimal_min' => 0,
                'optimal_max' => 21,
                'exceptional_min' => 0,
                'exceptional_max' => 15,
                'borderline_high_min' => 22,
                'needs_control_high_min' => 35,
                'critical_high_min' => 100,
                'unit' => 'мкмоль/л',
                'zone_mode' => 'bands',
                'health_direction' => 'lower_is_better',
                'display_precision' => 0,
                'source' => 'DSlog general-adult fallback scoring; lab-specific reference intervals and clinical context must override',
                'note' => 'Bilirubin interpretation depends on direct/indirect fractions and liver/hemolysis context.',
            ],

            'bilirubin-direct' => [
                'direction' => 'lower_better',
                'critical_low_max' => null,
                'needs_control_low_max' => null,
                'borderline_low_max' => null,
                'optimal_min' => 0,
                'optimal_max' => 5,
                'exceptional_min' => 0,
                'exceptional_max' => 3,
                'borderline_high_min' => 6,
                'needs_control_high_min' => 10,
                'critical_high_min' => 50,
                'unit' => 'мкмоль/л',
                'zone_mode' => 'bands',
                'health_direction' => 'lower_is_better',
                'display_precision' => 0,
                'source' => 'DSlog general-adult fallback scoring; lab-specific reference intervals and clinical context must override',
                'note' => 'Direct bilirubin elevation suggests cholestatic/hepatobiliary context.',
            ],

            'bilirubin-indirect' => [
                'direction' => 'lower_better',
                'critical_low_max' => null,
                'needs_control_low_max' => null,
                'borderline_low_max' => null,
                'optimal_min' => 0,
                'optimal_max' => 17,
                'exceptional_min' => 0,
                'exceptional_max' => 12,
                'borderline_high_min' => 18,
                'needs_control_high_min' => 30,
                'critical_high_min' => 80,
                'unit' => 'мкмоль/л',
                'zone_mode' => 'bands',
                'health_direction' => 'lower_is_better',
                'display_precision' => 0,
                'source' => 'DSlog general-adult fallback scoring; lab-specific reference intervals and clinical context must override',
                'note' => 'Indirect bilirubin depends on hemolysis, Gilbert syndrome and liver conjugation.',
            ],

            'amylase' => [
                'direction' => 'range',
                'critical_low_max' => null,
                'needs_control_low_max' => 20,
                'borderline_low_max' => 27,
                'optimal_min' => 28,
                'optimal_max' => 100,
                'exceptional_min' => null,
                'exceptional_max' => null,
                'borderline_high_min' => 101,
                'needs_control_high_min' => 150,
                'critical_high_min' => 300,
                'unit' => 'Ед/л',
                'zone_mode' => 'bands',
                'health_direction' => 'range_is_better',
                'display_precision' => 0,
                'source' => 'DSlog general-adult fallback scoring; lab-specific reference intervals and clinical context must override',
                'note' => 'Amylase is nonspecific; lipase is often more pancreas-specific.',
            ],

            'lipase' => [
                'direction' => 'range',
                'critical_low_max' => null,
                'needs_control_low_max' => 10,
                'borderline_low_max' => 12,
                'optimal_min' => 13,
                'optimal_max' => 60,
                'exceptional_min' => null,
                'exceptional_max' => null,
                'borderline_high_min' => 61,
                'needs_control_high_min' => 180,
                'critical_high_min' => 300,
                'unit' => 'Ед/л',
                'zone_mode' => 'bands',
                'health_direction' => 'range_is_better',
                'display_precision' => 0,
                'source' => 'DSlog general-adult fallback scoring; lab-specific reference intervals and clinical context must override',
                'note' => 'Lipase elevation can be clinically important; interpret with symptoms.',
            ],

            'ldh' => [
                'direction' => 'lower_better',
                'critical_low_max' => null,
                'needs_control_low_max' => null,
                'borderline_low_max' => null,
                'optimal_min' => 0,
                'optimal_max' => 220,
                'exceptional_min' => 0,
                'exceptional_max' => 180,
                'borderline_high_min' => 221,
                'needs_control_high_min' => 300,
                'critical_high_min' => 600,
                'unit' => 'Ед/л',
                'zone_mode' => 'bands',
                'health_direction' => 'lower_is_better',
                'display_precision' => 0,
                'source' => 'DSlog general-adult fallback scoring; lab-specific reference intervals and clinical context must override',
                'note' => 'LDH is nonspecific; consider hemolysis, liver, muscle and tissue injury.',
            ],

            'serum-iron' => [
                'direction' => 'range',
                'critical_low_max' => 5,
                'needs_control_low_max' => 9.9,
                'borderline_low_max' => 10.0,
                'optimal_min' => 10.1,
                'optimal_max' => 30.0,
                'exceptional_min' => null,
                'exceptional_max' => null,
                'borderline_high_min' => 30.1,
                'needs_control_high_min' => 35.0,
                'critical_high_min' => 50.0,
                'unit' => 'мкмоль/л',
                'zone_mode' => 'bands',
                'health_direction' => 'range_is_better',
                'display_precision' => 1,
                'source' => 'DSlog general-adult fallback scoring; lab-specific reference intervals and clinical context must override',
                'note' => 'Serum iron varies by time and diet; interpret with ferritin, transferrin/TIBC and TSAT.',
            ],

            'transferrin' => [
                'direction' => 'range',
                'critical_low_max' => 1.2,
                'needs_control_low_max' => 1.8,
                'borderline_low_max' => 1.99,
                'optimal_min' => 2.0,
                'optimal_max' => 3.6,
                'exceptional_min' => null,
                'exceptional_max' => null,
                'borderline_high_min' => 3.61,
                'needs_control_high_min' => 4.0,
                'critical_high_min' => 5.0,
                'unit' => 'г/л',
                'zone_mode' => 'bands',
                'health_direction' => 'range_is_better',
                'display_precision' => 1,
                'source' => 'DSlog general-adult fallback scoring; lab-specific reference intervals and clinical context must override',
                'note' => 'Transferrin changes with iron status, inflammation, liver and pregnancy.',
            ],

            'tibc' => [
                'direction' => 'range',
                'critical_low_max' => 30,
                'needs_control_low_max' => 44,
                'borderline_low_max' => 44.9,
                'optimal_min' => 45,
                'optimal_max' => 72,
                'exceptional_min' => null,
                'exceptional_max' => null,
                'borderline_high_min' => 73,
                'needs_control_high_min' => 85,
                'critical_high_min' => 100,
                'unit' => 'мкмоль/л',
                'zone_mode' => 'bands',
                'health_direction' => 'range_is_better',
                'display_precision' => 0,
                'source' => 'DSlog general-adult fallback scoring; lab-specific reference intervals and clinical context must override',
                'note' => 'TIBC interpretation overlaps with transferrin and iron deficiency/inflammation.',
            ],

            'uibc' => [
                'direction' => 'range',
                'critical_low_max' => 10,
                'needs_control_low_max' => 20,
                'borderline_low_max' => 23,
                'optimal_min' => 24,
                'optimal_max' => 60,
                'exceptional_min' => null,
                'exceptional_max' => null,
                'borderline_high_min' => 61,
                'needs_control_high_min' => 70,
                'critical_high_min' => 90,
                'unit' => 'мкмоль/л',
                'zone_mode' => 'bands',
                'health_direction' => 'range_is_better',
                'display_precision' => 0,
                'source' => 'DSlog general-adult fallback scoring; lab-specific reference intervals and clinical context must override',
                'note' => 'UIBC depends on serum iron and TIBC; supportive marker.',
            ],

            'transferrin-saturation' => [
                'direction' => 'range',
                'critical_low_max' => 10,
                'needs_control_low_max' => 15,
                'borderline_low_max' => 19,
                'optimal_min' => 20,
                'optimal_max' => 45,
                'exceptional_min' => null,
                'exceptional_max' => null,
                'borderline_high_min' => 46,
                'needs_control_high_min' => 55,
                'critical_high_min' => 70,
                'unit' => '%',
                'zone_mode' => 'bands',
                'health_direction' => 'range_is_better',
                'display_precision' => 0,
                'source' => 'DSlog general-adult fallback scoring; lab-specific reference intervals and clinical context must override',
                'note' => 'TSAT is important in iron deficiency/overload but must be interpreted with ferritin and inflammation.',
            ],

            'free-t4' => [
                'direction' => 'range',
                'critical_low_max' => 7,
                'needs_control_low_max' => 10,
                'borderline_low_max' => 11.9,
                'optimal_min' => 12,
                'optimal_max' => 22,
                'exceptional_min' => null,
                'exceptional_max' => null,
                'borderline_high_min' => 22.1,
                'needs_control_high_min' => 26,
                'critical_high_min' => 40,
                'unit' => 'пмоль/л',
                'zone_mode' => 'bands',
                'health_direction' => 'range_is_better',
                'display_precision' => 1,
                'source' => 'DSlog general-adult fallback scoring; lab-specific reference intervals and clinical context must override',
                'note' => 'Free T4 depends on assay and thyroid medication/pregnancy context.',
            ],

            'free-t3' => [
                'direction' => 'range',
                'critical_low_max' => 2.0,
                'needs_control_low_max' => 2.8,
                'borderline_low_max' => 3.0,
                'optimal_min' => 3.1,
                'optimal_max' => 6.8,
                'exceptional_min' => null,
                'exceptional_max' => null,
                'borderline_high_min' => 6.9,
                'needs_control_high_min' => 8.0,
                'critical_high_min' => 15.0,
                'unit' => 'пмоль/л',
                'zone_mode' => 'bands',
                'health_direction' => 'range_is_better',
                'display_precision' => 1,
                'source' => 'DSlog general-adult fallback scoring; lab-specific reference intervals and clinical context must override',
                'note' => 'Free T3 is assay/context dependent; interpret with TSH and free T4.',
            ],

            'total-t4' => [
                'direction' => 'range',
                'critical_low_max' => 40,
                'needs_control_low_max' => 55,
                'borderline_low_max' => 58,
                'optimal_min' => 59,
                'optimal_max' => 154,
                'exceptional_min' => null,
                'exceptional_max' => null,
                'borderline_high_min' => 155,
                'needs_control_high_min' => 180,
                'critical_high_min' => 250,
                'unit' => 'нмоль/л',
                'zone_mode' => 'bands',
                'health_direction' => 'range_is_better',
                'display_precision' => 0,
                'source' => 'DSlog general-adult fallback scoring; lab-specific reference intervals and clinical context must override',
                'note' => 'Total T4 depends strongly on binding proteins, estrogen and pregnancy.',
            ],

            'total-t3' => [
                'direction' => 'range',
                'critical_low_max' => 0.7,
                'needs_control_low_max' => 1.0,
                'borderline_low_max' => 1.1,
                'optimal_min' => 1.2,
                'optimal_max' => 2.8,
                'exceptional_min' => null,
                'exceptional_max' => null,
                'borderline_high_min' => 2.9,
                'needs_control_high_min' => 3.5,
                'critical_high_min' => 6.0,
                'unit' => 'нмоль/л',
                'zone_mode' => 'bands',
                'health_direction' => 'range_is_better',
                'display_precision' => 1,
                'source' => 'DSlog general-adult fallback scoring; lab-specific reference intervals and clinical context must override',
                'note' => 'Total T3 depends on binding proteins and clinical context.',
            ],

            'anti-tpo' => [
                'direction' => 'lower_better',
                'critical_low_max' => null,
                'needs_control_low_max' => null,
                'borderline_low_max' => null,
                'optimal_min' => 0,
                'optimal_max' => 34,
                'exceptional_min' => 0,
                'exceptional_max' => 10,
                'borderline_high_min' => 35,
                'needs_control_high_min' => 100,
                'critical_high_min' => 500,
                'unit' => 'МЕ/мл',
                'zone_mode' => 'bands',
                'health_direction' => 'lower_is_better',
                'display_precision' => 0,
                'source' => 'DSlog general-adult fallback scoring; lab-specific reference intervals and clinical context must override',
                'note' => 'Anti-TPO positivity suggests autoimmune thyroid context; thresholds are assay-dependent.',
            ],

            'anti-thyroglobulin' => [
                'direction' => 'lower_better',
                'critical_low_max' => null,
                'needs_control_low_max' => null,
                'borderline_low_max' => null,
                'optimal_min' => 0,
                'optimal_max' => 115,
                'exceptional_min' => 0,
                'exceptional_max' => 40,
                'borderline_high_min' => 116,
                'needs_control_high_min' => 300,
                'critical_high_min' => 1000,
                'unit' => 'МЕ/мл',
                'zone_mode' => 'bands',
                'health_direction' => 'lower_is_better',
                'display_precision' => 0,
                'source' => 'DSlog general-adult fallback scoring; lab-specific reference intervals and clinical context must override',
                'note' => 'Anti-thyroglobulin thresholds are assay-dependent and context-specific.',
            ],

            'trab' => [
                'direction' => 'lower_better',
                'critical_low_max' => null,
                'needs_control_low_max' => null,
                'borderline_low_max' => null,
                'optimal_min' => 0,
                'optimal_max' => 1.75,
                'exceptional_min' => 0,
                'exceptional_max' => 1.0,
                'borderline_high_min' => 1.76,
                'needs_control_high_min' => 3.0,
                'critical_high_min' => 10.0,
                'unit' => 'МЕ/л',
                'zone_mode' => 'bands',
                'health_direction' => 'lower_is_better',
                'display_precision' => 2,
                'source' => 'DSlog general-adult fallback scoring; lab-specific reference intervals and clinical context must override',
                'note' => 'TRAb is mainly for Graves disease context; assay-dependent.',
            ],

            'inr' => [
                'direction' => 'range',
                'critical_low_max' => null,
                'needs_control_low_max' => 0.7,
                'borderline_low_max' => 0.79,
                'optimal_min' => 0.8,
                'optimal_max' => 1.2,
                'exceptional_min' => null,
                'exceptional_max' => null,
                'borderline_high_min' => 1.21,
                'needs_control_high_min' => 1.5,
                'critical_high_min' => 3.0,
                'unit' => '',
                'zone_mode' => 'bands',
                'health_direction' => 'range_is_better',
                'display_precision' => 2,
                'source' => 'DSlog general-adult fallback scoring; lab-specific reference intervals and clinical context must override',
                'note' => 'INR therapeutic ranges differ if anticoagulated; this is non-anticoagulated adult fallback.',
            ],

            'pt' => [
                'direction' => 'range',
                'critical_low_max' => null,
                'needs_control_low_max' => 9,
                'borderline_low_max' => 10.9,
                'optimal_min' => 11,
                'optimal_max' => 15,
                'exceptional_min' => null,
                'exceptional_max' => null,
                'borderline_high_min' => 15.1,
                'needs_control_high_min' => 18,
                'critical_high_min' => 30,
                'unit' => 'с',
                'zone_mode' => 'bands',
                'health_direction' => 'range_is_better',
                'display_precision' => 1,
                'source' => 'DSlog general-adult fallback scoring; lab-specific reference intervals and clinical context must override',
                'note' => 'PT depends on reagent/lab and anticoagulation status.',
            ],

            'aptt' => [
                'direction' => 'range',
                'critical_low_max' => 20,
                'needs_control_low_max' => 24,
                'borderline_low_max' => 24.9,
                'optimal_min' => 25,
                'optimal_max' => 35,
                'exceptional_min' => null,
                'exceptional_max' => null,
                'borderline_high_min' => 35.1,
                'needs_control_high_min' => 45,
                'critical_high_min' => 70,
                'unit' => 'с',
                'zone_mode' => 'bands',
                'health_direction' => 'range_is_better',
                'display_precision' => 1,
                'source' => 'DSlog general-adult fallback scoring; lab-specific reference intervals and clinical context must override',
                'note' => 'APTT depends on reagent/lab and heparin/anticoagulant context.',
            ],

            'fibrinogen' => [
                'direction' => 'range',
                'critical_low_max' => 1.0,
                'needs_control_low_max' => 1.9,
                'borderline_low_max' => 1.99,
                'optimal_min' => 2.0,
                'optimal_max' => 4.0,
                'exceptional_min' => null,
                'exceptional_max' => null,
                'borderline_high_min' => 4.1,
                'needs_control_high_min' => 5.0,
                'critical_high_min' => 7.0,
                'unit' => 'г/л',
                'zone_mode' => 'bands',
                'health_direction' => 'range_is_better',
                'display_precision' => 1,
                'source' => 'DSlog general-adult fallback scoring; lab-specific reference intervals and clinical context must override',
                'note' => 'Fibrinogen rises with inflammation and falls with consumption/liver disease.',
            ],

            'd-dimer' => [
                'direction' => 'lower_better',
                'critical_low_max' => null,
                'needs_control_low_max' => null,
                'borderline_low_max' => null,
                'optimal_min' => 0,
                'optimal_max' => 0.5,
                'exceptional_min' => 0,
                'exceptional_max' => 0.25,
                'borderline_high_min' => 0.51,
                'needs_control_high_min' => 1.0,
                'critical_high_min' => 5.0,
                'unit' => 'мг/л FEU',
                'zone_mode' => 'bands',
                'health_direction' => 'lower_is_better',
                'display_precision' => 2,
                'source' => 'DSlog general-adult fallback scoring; lab-specific reference intervals and clinical context must override',
                'note' => 'D-dimer is age/context/assay dependent; not diagnostic alone.',
            ],

            'hs-crp' => [
                'direction' => 'lower_better',
                'critical_low_max' => null,
                'needs_control_low_max' => null,
                'borderline_low_max' => null,
                'optimal_min' => 0,
                'optimal_max' => 1.0,
                'exceptional_min' => 0,
                'exceptional_max' => 0.5,
                'borderline_high_min' => 1.1,
                'needs_control_high_min' => 3.1,
                'critical_high_min' => 10.1,
                'unit' => 'мг/л',
                'zone_mode' => 'bands',
                'health_direction' => 'lower_is_better',
                'display_precision' => 1,
                'source' => 'DSlog general-adult fallback scoring; lab-specific reference intervals and clinical context must override',
                'note' => 'hs-CRP cardiometabolic risk context; acute infection/injury can dominate.',
            ],

            'homocysteine' => [
                'direction' => 'lower_better',
                'critical_low_max' => null,
                'needs_control_low_max' => null,
                'borderline_low_max' => null,
                'optimal_min' => 0,
                'optimal_max' => 10.0,
                'exceptional_min' => 0,
                'exceptional_max' => 8.0,
                'borderline_high_min' => 10.1,
                'needs_control_high_min' => 15.1,
                'critical_high_min' => 30.0,
                'unit' => 'мкмоль/л',
                'zone_mode' => 'bands',
                'health_direction' => 'lower_is_better',
                'display_precision' => 1,
                'source' => 'DSlog general-adult fallback scoring; lab-specific reference intervals and clinical context must override',
                'note' => 'Homocysteine depends on B12/folate/B6, kidney function and genetics.',
            ],

            'apolipoprotein-b' => [
                'direction' => 'lower_better',
                'critical_low_max' => null,
                'needs_control_low_max' => null,
                'borderline_low_max' => null,
                'optimal_min' => 0,
                'optimal_max' => 0.9,
                'exceptional_min' => 0,
                'exceptional_max' => 0.8,
                'borderline_high_min' => 0.91,
                'needs_control_high_min' => 1.1,
                'critical_high_min' => 1.5,
                'unit' => 'г/л',
                'zone_mode' => 'bands',
                'health_direction' => 'lower_is_better',
                'display_precision' => 2,
                'source' => 'DSlog general-adult fallback scoring; lab-specific reference intervals and clinical context must override',
                'note' => 'ApoB targets depend on cardiovascular risk profile; broad fallback.',
            ],

            'apolipoprotein-a1' => [
                'direction' => 'higher_better',
                'critical_low_max' => 0.9,
                'needs_control_low_max' => 1.0,
                'borderline_low_max' => 1.1,
                'optimal_min' => 1.2,
                'optimal_max' => 2.0,
                'exceptional_min' => 1.5,
                'exceptional_max' => 2.2,
                'borderline_high_min' => null,
                'needs_control_high_min' => null,
                'critical_high_min' => null,
                'unit' => 'г/л',
                'zone_mode' => 'bands',
                'health_direction' => 'higher_is_better',
                'display_precision' => 2,
                'source' => 'DSlog general-adult fallback scoring; lab-specific reference intervals and clinical context must override',
                'note' => 'ApoA1 is sex/context dependent; supportive lipid marker.',
            ],

            'lipoprotein-a' => [
                'direction' => 'lower_better',
                'critical_low_max' => null,
                'needs_control_low_max' => null,
                'borderline_low_max' => null,
                'optimal_min' => 0,
                'optimal_max' => 30,
                'exceptional_min' => 0,
                'exceptional_max' => 10,
                'borderline_high_min' => 31,
                'needs_control_high_min' => 50,
                'critical_high_min' => 100,
                'unit' => 'мг/дл',
                'zone_mode' => 'bands',
                'health_direction' => 'lower_is_better',
                'display_precision' => 0,
                'source' => 'DSlog general-adult fallback scoring; lab-specific reference intervals and clinical context must override',
                'note' => 'Lp(a) units vary; mg/dL and nmol/L are not directly interchangeable.',
            ],

            'non-hdl-cholesterol' => [
                'direction' => 'lower_better',
                'critical_low_max' => null,
                'needs_control_low_max' => null,
                'borderline_low_max' => null,
                'optimal_min' => 0,
                'optimal_max' => 3.4,
                'exceptional_min' => 0,
                'exceptional_max' => 2.6,
                'borderline_high_min' => 3.5,
                'needs_control_high_min' => 4.1,
                'critical_high_min' => 5.7,
                'unit' => 'ммоль/л',
                'zone_mode' => 'bands',
                'health_direction' => 'lower_is_better',
                'display_precision' => 1,
                'source' => 'DSlog general-adult fallback scoring; lab-specific reference intervals and clinical context must override',
                'note' => 'Non-HDL targets depend on cardiovascular risk profile.',
            ],

            'zinc' => [
                'direction' => 'range',
                'critical_low_max' => 7,
                'needs_control_low_max' => 10,
                'borderline_low_max' => 10.6,
                'optimal_min' => 10.7,
                'optimal_max' => 18.4,
                'exceptional_min' => null,
                'exceptional_max' => null,
                'borderline_high_min' => 18.5,
                'needs_control_high_min' => 22,
                'critical_high_min' => 30,
                'unit' => 'мкмоль/л',
                'zone_mode' => 'bands',
                'health_direction' => 'range_is_better',
                'display_precision' => 1,
                'source' => 'DSlog general-adult fallback scoring; lab-specific reference intervals and clinical context must override',
                'note' => 'Zinc is sample/lab dependent; interpret carefully.',
            ],

            'copper' => [
                'direction' => 'range',
                'critical_low_max' => 7,
                'needs_control_low_max' => 10,
                'borderline_low_max' => 10.9,
                'optimal_min' => 11,
                'optimal_max' => 24,
                'exceptional_min' => null,
                'exceptional_max' => null,
                'borderline_high_min' => 24.1,
                'needs_control_high_min' => 30,
                'critical_high_min' => 45,
                'unit' => 'мкмоль/л',
                'zone_mode' => 'bands',
                'health_direction' => 'range_is_better',
                'display_precision' => 1,
                'source' => 'DSlog general-adult fallback scoring; lab-specific reference intervals and clinical context must override',
                'note' => 'Copper depends on inflammation, estrogen/pregnancy and ceruloplasmin.',
            ],

            'ceruloplasmin' => [
                'direction' => 'range',
                'critical_low_max' => 0.1,
                'needs_control_low_max' => 0.19,
                'borderline_low_max' => 0.19,
                'optimal_min' => 0.2,
                'optimal_max' => 0.6,
                'exceptional_min' => null,
                'exceptional_max' => null,
                'borderline_high_min' => 0.61,
                'needs_control_high_min' => 0.8,
                'critical_high_min' => 1.2,
                'unit' => 'г/л',
                'zone_mode' => 'bands',
                'health_direction' => 'range_is_better',
                'display_precision' => 2,
                'source' => 'DSlog general-adult fallback scoring; lab-specific reference intervals and clinical context must override',
                'note' => 'Ceruloplasmin is inflammation/estrogen dependent; Wilson disease context is special.',
            ],

            'pth' => [
                'direction' => 'range',
                'critical_low_max' => 5,
                'needs_control_low_max' => 14,
                'borderline_low_max' => 14.9,
                'optimal_min' => 15,
                'optimal_max' => 65,
                'exceptional_min' => null,
                'exceptional_max' => null,
                'borderline_high_min' => 66,
                'needs_control_high_min' => 100,
                'critical_high_min' => 300,
                'unit' => 'пг/мл',
                'zone_mode' => 'bands',
                'health_direction' => 'range_is_better',
                'display_precision' => 0,
                'source' => 'DSlog general-adult fallback scoring; lab-specific reference intervals and clinical context must override',
                'note' => 'PTH interpretation requires calcium, vitamin D and kidney function.',
            ],

            /*
            Deferred from this pack on purpose: tumor markers, infectious serology, stool qualitative tests, urine qualitative/binary tests, reproductive hormones, ACTH/renin/aldosterone/cortisol, highly assay-specific immunology and pregnancy-specific markers. These need separate profile/context rules, not broad general-adult fallback thresholds.
            */



        ];

        foreach ($rules as $slug => $rule) {
            $marker = Marker::where('slug', $slug)->first();

            if (!$marker) {
                continue;
            }

            MarkerScoringRule::updateOrCreate(
                [
                    'marker_id' => $marker->id,
                    'scoring_profile_id' => $profile->id,
                ],
                [
                    'direction' => $rule['direction'],

                    'critical_low_max' => $rule['critical_low_max'] ?? null,
                    'needs_control_low_max' => $rule['needs_control_low_max'] ?? null,
                    'borderline_low_max' => $rule['borderline_low_max'] ?? null,

                    'optimal_min' => $rule['optimal_min'] ?? null,
                    'optimal_max' => $rule['optimal_max'] ?? null,

                    'exceptional_min' => $rule['exceptional_min'] ?? null,
                    'exceptional_max' => $rule['exceptional_max'] ?? null,

                    'borderline_high_min' => $rule['borderline_high_min'] ?? null,
                    'needs_control_high_min' => $rule['needs_control_high_min'] ?? null,
                    'critical_high_min' => $rule['critical_high_min'] ?? null,

                    'unit' => $rule['unit'] ?? null,

                    'source' => $rule['source'] ?? 'DSlog MVP scoring',
                    'note' => $rule['note'] ?? null,

                    'zone_mode' => $rule['zone_mode'] ?? 'bands',
                    'health_direction' => $rule['health_direction'] ?? null,
                    'display_precision' => $rule['display_precision'] ?? 1,

                    'is_active' => true,
                ]
            );
        }
    
            
            /*
        |--------------------------------------------------------------------------
        | Sex-specific adult scoring rules — quality pack v1
        |--------------------------------------------------------------------------
        |
        | Paste this block inside MarkerScoringRulesSeeder::run(), after the
        | general-adult rules.
        |
        | Scope:
        | - only high-confidence sex-specific adult differences;
        | - not pregnancy, not cycle hormones, not athlete/longevity optimization;
        | - lab-specific reference ranges should still have priority over this
        |   product fallback layer.
        |
        */

        $sexAdultProfiles = MarkerScoringProfile::query()
            ->whereIn('slug', [
                'male-adult',
                'female-adult',
            ])
            ->get()
            ->keyBy('slug');

        $sexAdultRules = [

            /*
            |--------------------------------------------------------------------------
            | CBC / red blood cell markers
            |--------------------------------------------------------------------------
            */

            'hemoglobin' => [
                'male-adult' => [
                    'direction' => 'range',
                    'critical_low_max' => 90,
                    'needs_control_low_max' => 129,
                    'borderline_low_max' => 137,
                    'optimal_min' => 138,
                    'optimal_max' => 172,
                    'exceptional_min' => null,
                    'exceptional_max' => null,
                    'borderline_high_min' => 173,
                    'needs_control_high_min' => 180,
                    'critical_high_min' => 190,
                    'unit' => 'г/л',
                    'display_precision' => 0,
                    'note' => 'Male adult hemoglobin scoring. Conservative fallback; lab-specific reference range should take priority.',
                ],
                'female-adult' => [
                    'direction' => 'range',
                    'critical_low_max' => 80,
                    'needs_control_low_max' => 110,
                    'borderline_low_max' => 120,
                    'optimal_min' => 121,
                    'optimal_max' => 151,
                    'exceptional_min' => null,
                    'exceptional_max' => null,
                    'borderline_high_min' => 152,
                    'needs_control_high_min' => 160,
                    'critical_high_min' => 170,
                    'unit' => 'г/л',
                    'display_precision' => 0,
                    'note' => 'Female adult hemoglobin scoring outside pregnancy. Conservative fallback; lab-specific reference range should take priority.',
                ],
            ],

            'hematocrit' => [
                'male-adult' => [
                    'direction' => 'range',
                    'critical_low_max' => 30,
                    'needs_control_low_max' => 38,
                    'borderline_low_max' => 40,
                    'optimal_min' => 41,
                    'optimal_max' => 50,
                    'exceptional_min' => null,
                    'exceptional_max' => null,
                    'borderline_high_min' => 51,
                    'needs_control_high_min' => 54,
                    'critical_high_min' => 60,
                    'unit' => '%',
                    'display_precision' => 1,
                    'note' => 'Male adult hematocrit scoring. Conservative fallback; lab-specific reference range should take priority.',
                ],
                'female-adult' => [
                    'direction' => 'range',
                    'critical_low_max' => 27,
                    'needs_control_low_max' => 33,
                    'borderline_low_max' => 35,
                    'optimal_min' => 36,
                    'optimal_max' => 44,
                    'exceptional_min' => null,
                    'exceptional_max' => null,
                    'borderline_high_min' => 45,
                    'needs_control_high_min' => 48,
                    'critical_high_min' => 55,
                    'unit' => '%',
                    'display_precision' => 1,
                    'note' => 'Female adult hematocrit scoring outside pregnancy. Conservative fallback; lab-specific reference range should take priority.',
                ],
            ],

            'rbc' => [
                'male-adult' => [
                    'direction' => 'range',
                    'critical_low_max' => 3.5,
                    'needs_control_low_max' => 4.1,
                    'borderline_low_max' => 4.49,
                    'optimal_min' => 4.5,
                    'optimal_max' => 5.9,
                    'exceptional_min' => null,
                    'exceptional_max' => null,
                    'borderline_high_min' => 5.91,
                    'needs_control_high_min' => 6.2,
                    'critical_high_min' => 6.8,
                    'unit' => '10^12/л',
                    'display_precision' => 2,
                    'note' => 'Male adult RBC scoring. Conservative fallback; lab-specific reference range should take priority.',
                ],
                'female-adult' => [
                    'direction' => 'range',
                    'critical_low_max' => 3.2,
                    'needs_control_low_max' => 3.8,
                    'borderline_low_max' => 4.09,
                    'optimal_min' => 4.1,
                    'optimal_max' => 5.1,
                    'exceptional_min' => null,
                    'exceptional_max' => null,
                    'borderline_high_min' => 5.11,
                    'needs_control_high_min' => 5.5,
                    'critical_high_min' => 6.2,
                    'unit' => '10^12/л',
                    'display_precision' => 2,
                    'note' => 'Female adult RBC scoring outside pregnancy. Conservative fallback; lab-specific reference range should take priority.',
                ],
            ],

            /*
            |--------------------------------------------------------------------------
            | Iron stores / iron status
            |--------------------------------------------------------------------------
            */

            'ferritin' => [
                'male-adult' => [
                    'direction' => 'range',
                    'critical_low_max' => 12,
                    'needs_control_low_max' => 29,
                    'borderline_low_max' => 49,
                    'optimal_min' => 50,
                    'optimal_max' => 200,
                    'exceptional_min' => null,
                    'exceptional_max' => null,
                    'borderline_high_min' => 201,
                    'needs_control_high_min' => 400,
                    'critical_high_min' => 800,
                    'unit' => 'нг/мл',
                    'display_precision' => 0,
                    'note' => 'Male adult ferritin scoring. Ferritin is inflammation-sensitive; interpret with CRP and clinical context.',
                ],
                'female-adult' => [
                    'direction' => 'range',
                    'critical_low_max' => 8,
                    'needs_control_low_max' => 15,
                    'borderline_low_max' => 29,
                    'optimal_min' => 30,
                    'optimal_max' => 120,
                    'exceptional_min' => null,
                    'exceptional_max' => null,
                    'borderline_high_min' => 121,
                    'needs_control_high_min' => 200,
                    'critical_high_min' => 500,
                    'unit' => 'нг/мл',
                    'display_precision' => 0,
                    'note' => 'Female adult ferritin scoring outside pregnancy. Ferritin is inflammation-sensitive; interpret with CRP and menstrual/bleeding context.',
                ],
            ],

            'serum-iron' => [
                'male-adult' => [
                    'direction' => 'range',
                    'critical_low_max' => 5,
                    'needs_control_low_max' => 10,
                    'borderline_low_max' => 11.5,
                    'optimal_min' => 11.6,
                    'optimal_max' => 31.3,
                    'exceptional_min' => null,
                    'exceptional_max' => null,
                    'borderline_high_min' => 31.4,
                    'needs_control_high_min' => 40,
                    'critical_high_min' => 55,
                    'unit' => 'мкмоль/л',
                    'display_precision' => 1,
                    'note' => 'Male adult serum iron scoring. Serum iron varies with timing, fasting status and supplementation; use with ferritin/transferrin/TIBC.',
                ],
                'female-adult' => [
                    'direction' => 'range',
                    'critical_low_max' => 4,
                    'needs_control_low_max' => 8,
                    'borderline_low_max' => 8.9,
                    'optimal_min' => 9,
                    'optimal_max' => 30.4,
                    'exceptional_min' => null,
                    'exceptional_max' => null,
                    'borderline_high_min' => 30.5,
                    'needs_control_high_min' => 40,
                    'critical_high_min' => 55,
                    'unit' => 'мкмоль/л',
                    'display_precision' => 1,
                    'note' => 'Female adult serum iron scoring outside pregnancy. Serum iron varies with timing, fasting status and supplementation; use with ferritin/transferrin/TIBC.',
                ],
            ],

            /*
            |--------------------------------------------------------------------------
            | Kidney / muscle-mass influenced markers
            |--------------------------------------------------------------------------
            */

            'creatinine' => [
                'male-adult' => [
                    'direction' => 'range',
                    'critical_low_max' => 45,
                    'needs_control_low_max' => 55,
                    'borderline_low_max' => 61,
                    'optimal_min' => 62,
                    'optimal_max' => 106,
                    'exceptional_min' => null,
                    'exceptional_max' => null,
                    'borderline_high_min' => 107,
                    'needs_control_high_min' => 116,
                    'critical_high_min' => 180,
                    'unit' => 'мкмоль/л',
                    'display_precision' => 0,
                    'note' => 'Male adult creatinine scoring. Strongly depends on muscle mass; eGFR and clinical context are more important for kidney function.',
                ],
                'female-adult' => [
                    'direction' => 'range',
                    'critical_low_max' => 35,
                    'needs_control_low_max' => 40,
                    'borderline_low_max' => 43,
                    'optimal_min' => 44,
                    'optimal_max' => 84,
                    'exceptional_min' => null,
                    'exceptional_max' => null,
                    'borderline_high_min' => 85,
                    'needs_control_high_min' => 98,
                    'critical_high_min' => 150,
                    'unit' => 'мкмоль/л',
                    'display_precision' => 0,
                    'note' => 'Female adult creatinine scoring outside pregnancy. Strongly depends on muscle mass; eGFR and clinical context are more important for kidney function.',
                ],
            ],

            'uric-acid' => [
                'male-adult' => [
                    'direction' => 'range',
                    'critical_low_max' => 120,
                    'needs_control_low_max' => 180,
                    'borderline_low_max' => 207,
                    'optimal_min' => 208,
                    'optimal_max' => 428,
                    'exceptional_min' => null,
                    'exceptional_max' => null,
                    'borderline_high_min' => 429,
                    'needs_control_high_min' => 500,
                    'critical_high_min' => 700,
                    'unit' => 'мкмоль/л',
                    'display_precision' => 0,
                    'note' => 'Male adult uric acid scoring. Interpret with kidney function, gout history, medications and diet.',
                ],
                'female-adult' => [
                    'direction' => 'range',
                    'critical_low_max' => 100,
                    'needs_control_low_max' => 135,
                    'borderline_low_max' => 154,
                    'optimal_min' => 155,
                    'optimal_max' => 357,
                    'exceptional_min' => null,
                    'exceptional_max' => null,
                    'borderline_high_min' => 358,
                    'needs_control_high_min' => 420,
                    'critical_high_min' => 600,
                    'unit' => 'мкмоль/л',
                    'display_precision' => 0,
                    'note' => 'Female adult uric acid scoring outside pregnancy. Interpret with kidney function, gout history, medications and diet.',
                ],
            ],

            /*
            |--------------------------------------------------------------------------
            | Lipids
            |--------------------------------------------------------------------------
            */

            'hdl' => [
                'male-adult' => [
                    'direction' => 'higher_better',
                    'critical_low_max' => 0.7,
                    'needs_control_low_max' => 0.89,
                    'borderline_low_max' => 0.99,
                    'optimal_min' => 1.0,
                    'optimal_max' => 1.89,
                    'exceptional_min' => 1.9,
                    'exceptional_max' => 3.0,
                    'borderline_high_min' => null,
                    'needs_control_high_min' => null,
                    'critical_high_min' => null,
                    'unit' => 'ммоль/л',
                    'display_precision' => 2,
                    'note' => 'Male adult HDL scoring. Higher is generally better, but cardiovascular risk should be assessed with the full lipid profile and risk factors.',
                ],
                'female-adult' => [
                    'direction' => 'higher_better',
                    'critical_low_max' => 0.8,
                    'needs_control_low_max' => 1.09,
                    'borderline_low_max' => 1.19,
                    'optimal_min' => 1.2,
                    'optimal_max' => 1.99,
                    'exceptional_min' => 2.0,
                    'exceptional_max' => 3.2,
                    'borderline_high_min' => null,
                    'needs_control_high_min' => null,
                    'critical_high_min' => null,
                    'unit' => 'ммоль/л',
                    'display_precision' => 2,
                    'note' => 'Female adult HDL scoring outside pregnancy. Higher is generally better, but cardiovascular risk should be assessed with the full lipid profile and risk factors.',
                ],
            ],

            'apolipoprotein-a1' => [
                'male-adult' => [
                    'direction' => 'higher_better',
                    'critical_low_max' => 0.8,
                    'needs_control_low_max' => 1.0,
                    'borderline_low_max' => 1.09,
                    'optimal_min' => 1.10,
                    'optimal_max' => 1.80,
                    'exceptional_min' => 1.81,
                    'exceptional_max' => 2.40,
                    'borderline_high_min' => null,
                    'needs_control_high_min' => null,
                    'critical_high_min' => null,
                    'unit' => 'г/л',
                    'display_precision' => 2,
                    'note' => 'Male adult ApoA1 scoring. Use with ApoB, HDL and overall cardiovascular risk.',
                ],
                'female-adult' => [
                    'direction' => 'higher_better',
                    'critical_low_max' => 0.9,
                    'needs_control_low_max' => 1.10,
                    'borderline_low_max' => 1.19,
                    'optimal_min' => 1.20,
                    'optimal_max' => 1.90,
                    'exceptional_min' => 1.91,
                    'exceptional_max' => 2.50,
                    'borderline_high_min' => null,
                    'needs_control_high_min' => null,
                    'critical_high_min' => null,
                    'unit' => 'г/л',
                    'display_precision' => 2,
                    'note' => 'Female adult ApoA1 scoring outside pregnancy. Use with ApoB, HDL and overall cardiovascular risk.',
                ],
            ],

            /*
            |--------------------------------------------------------------------------
            | Enzymes with common sex-specific upper ranges
            |--------------------------------------------------------------------------
            */

            'ggt' => [
                'male-adult' => [
                    'direction' => 'lower_better',
                    'critical_low_max' => null,
                    'needs_control_low_max' => null,
                    'borderline_low_max' => null,
                    'optimal_min' => 0,
                    'optimal_max' => 55,
                    'exceptional_min' => 0,
                    'exceptional_max' => 35,
                    'borderline_high_min' => 56,
                    'needs_control_high_min' => 72,
                    'critical_high_min' => 150,
                    'unit' => 'Ед/л',
                    'display_precision' => 0,
                    'note' => 'Male adult GGT scoring. GGT is method- and lab-dependent; interpret with ALT/AST/ALP/bilirubin and alcohol/medication context.',
                ],
                'female-adult' => [
                    'direction' => 'lower_better',
                    'critical_low_max' => null,
                    'needs_control_low_max' => null,
                    'borderline_low_max' => null,
                    'optimal_min' => 0,
                    'optimal_max' => 38,
                    'exceptional_min' => 0,
                    'exceptional_max' => 25,
                    'borderline_high_min' => 39,
                    'needs_control_high_min' => 43,
                    'critical_high_min' => 120,
                    'unit' => 'Ед/л',
                    'display_precision' => 0,
                    'note' => 'Female adult GGT scoring outside pregnancy. GGT is method- and lab-dependent; interpret with ALT/AST/ALP/bilirubin and alcohol/medication context.',
                ],
            ],

            'ck' => [
                'male-adult' => [
                    'direction' => 'lower_better',
                    'critical_low_max' => null,
                    'needs_control_low_max' => null,
                    'borderline_low_max' => null,
                    'optimal_min' => 20,
                    'optimal_max' => 200,
                    'exceptional_min' => null,
                    'exceptional_max' => null,
                    'borderline_high_min' => 201,
                    'needs_control_high_min' => 400,
                    'critical_high_min' => 1000,
                    'unit' => 'Ед/л',
                    'display_precision' => 0,
                    'note' => 'Male adult CK scoring. CK is highly affected by exercise, muscle mass, injections and trauma; do not interpret without context.',
                ],
                'female-adult' => [
                    'direction' => 'lower_better',
                    'critical_low_max' => null,
                    'needs_control_low_max' => null,
                    'borderline_low_max' => null,
                    'optimal_min' => 20,
                    'optimal_max' => 170,
                    'exceptional_min' => null,
                    'exceptional_max' => null,
                    'borderline_high_min' => 171,
                    'needs_control_high_min' => 350,
                    'critical_high_min' => 1000,
                    'unit' => 'Ед/л',
                    'display_precision' => 0,
                    'note' => 'Female adult CK scoring outside pregnancy. CK is highly affected by exercise, muscle mass, injections and trauma; do not interpret without context.',
                ],
            ],
        ];

        foreach ($sexAdultRules as $markerSlug => $rulesByProfile) {

            $marker = Marker::where('slug', $markerSlug)->first();

            if (!$marker) {
                continue;
            }

            foreach ($rulesByProfile as $profileSlug => $rule) {

                $profile = $sexAdultProfiles[$profileSlug] ?? null;

                if (!$profile) {
                    continue;
                }

                MarkerScoringRule::updateOrCreate(
                    [
                        'marker_id' => $marker->id,
                        'scoring_profile_id' => $profile->id,
                    ],
                    [
                        'direction' => $rule['direction'],

                        'critical_low_max' => $rule['critical_low_max'],
                        'needs_control_low_max' => $rule['needs_control_low_max'],
                        'borderline_low_max' => $rule['borderline_low_max'],

                        'optimal_min' => $rule['optimal_min'],
                        'optimal_max' => $rule['optimal_max'],

                        'exceptional_min' => $rule['exceptional_min'],
                        'exceptional_max' => $rule['exceptional_max'],

                        'borderline_high_min' => $rule['borderline_high_min'],
                        'needs_control_high_min' => $rule['needs_control_high_min'],
                        'critical_high_min' => $rule['critical_high_min'],

                        'unit' => $rule['unit'],

                        'display_precision' => $rule['display_precision'],
                        'zone_mode' => 'bands',
                        'health_direction' => match ($rule['direction']) {
                            'higher_better' => 'higher_is_better',
                            'lower_better' => 'lower_is_better',
                            default => 'range_is_better',
                        },

                        'source' => 'DSlog sex-specific adult scoring quality pack v1',
                        'note' => $rule['note'],

                        'is_active' => true,
                    ]
                );
            }
        }

        /*
        |--------------------------------------------------------------------------
        | Sex-specific adult scoring rules — quality pack v2
        |--------------------------------------------------------------------------
        |
        | Paste this block inside MarkerScoringRulesSeeder::run(), after the
        | general-adult blocks and after sex-adult quality pack v1.
        |
        | Scope:
        | - only profile-specific male-adult / female-adult fallback rules;
        | - not pregnancy, not menstrual-cycle phase logic, not athlete/longevity;
        | - lab-specific reference intervals and clinical context must override;
        | - deliberately conservative: skipped markers where sex-specific adult
        |   fallback would be too method/age/context-dependent for safe automation.
        |
        | Included in v2:
        | - ALT / AST / ALP: sex-aware fallback refinements for liver/bone enzyme UI;
        | - testosterone-total: strongly sex-specific, but age/method dependent;
        | - prolactin: sex-aware nonpregnant adult fallback;
        | - SHBG: strongly sex-influenced, but hormone/medication context dependent.
        |
        | Deferred intentionally:
        | - testosterone-free: assay/calculation dependent, method-specific;
        | - DHEA-S: strongly age-dependent; should be age-banded later;
        | - estradiol / progesterone / LH / FSH: require cycle/menopause/pregnancy
        |   context and should not be reduced to a simple sex-adult rule;
        | - PSA: male-only and age/risk-specific; create a separate prostate/risk pack.
        |
        */

        $sexAdultProfilesV2 = MarkerScoringProfile::query()
            ->whereIn('slug', [
                'male-adult',
                'female-adult',
            ])
            ->get()
            ->keyBy('slug');

        $sexAdultRulesV2 = [

            /*
            |--------------------------------------------------------------------------
            | Liver / cholestasis / bone enzymes
            |--------------------------------------------------------------------------
            */

            'alt' => [
                'male-adult' => [
                    'direction' => 'lower_better',
                    'critical_low_max' => null,
                    'needs_control_low_max' => null,
                    'borderline_low_max' => null,
                    'optimal_min' => 4,
                    'optimal_max' => 35,
                    'exceptional_min' => 8,
                    'exceptional_max' => 28,
                    'borderline_high_min' => 36,
                    'needs_control_high_min' => 55,
                    'critical_high_min' => 150,
                    'unit' => 'Ед/л',
                    'display_precision' => 0,
                    'note' => 'Male adult ALT scoring. Conservative sex-aware fallback; ALT is method/lab dependent and must be interpreted with AST, GGT, bilirubin, medications, alcohol and symptoms.',
                ],
                'female-adult' => [
                    'direction' => 'lower_better',
                    'critical_low_max' => null,
                    'needs_control_low_max' => null,
                    'borderline_low_max' => null,
                    'optimal_min' => 4,
                    'optimal_max' => 30,
                    'exceptional_min' => 8,
                    'exceptional_max' => 24,
                    'borderline_high_min' => 31,
                    'needs_control_high_min' => 45,
                    'critical_high_min' => 150,
                    'unit' => 'Ед/л',
                    'display_precision' => 0,
                    'note' => 'Female adult ALT scoring outside pregnancy. Conservative sex-aware fallback; ALT is method/lab dependent and must be interpreted with AST, GGT, bilirubin, medications, alcohol and symptoms.',
                ],
            ],

            'ast' => [
                'male-adult' => [
                    'direction' => 'lower_better',
                    'critical_low_max' => null,
                    'needs_control_low_max' => null,
                    'borderline_low_max' => null,
                    'optimal_min' => 8,
                    'optimal_max' => 33,
                    'exceptional_min' => 10,
                    'exceptional_max' => 26,
                    'borderline_high_min' => 34,
                    'needs_control_high_min' => 55,
                    'critical_high_min' => 150,
                    'unit' => 'Ед/л',
                    'display_precision' => 0,
                    'note' => 'Male adult AST scoring. Conservative fallback; AST is less liver-specific than ALT and can rise with muscle injury, exercise or myocardial injury.',
                ],
                'female-adult' => [
                    'direction' => 'lower_better',
                    'critical_low_max' => null,
                    'needs_control_low_max' => null,
                    'borderline_low_max' => null,
                    'optimal_min' => 8,
                    'optimal_max' => 30,
                    'exceptional_min' => 10,
                    'exceptional_max' => 24,
                    'borderline_high_min' => 31,
                    'needs_control_high_min' => 45,
                    'critical_high_min' => 150,
                    'unit' => 'Ед/л',
                    'display_precision' => 0,
                    'note' => 'Female adult AST scoring outside pregnancy. Conservative fallback; AST is less liver-specific than ALT and can rise with muscle injury, exercise or myocardial injury.',
                ],
            ],

            'alp' => [
                'male-adult' => [
                    'direction' => 'range',
                    'critical_low_max' => null,
                    'needs_control_low_max' => 30,
                    'borderline_low_max' => 39,
                    'optimal_min' => 40,
                    'optimal_max' => 129,
                    'exceptional_min' => null,
                    'exceptional_max' => null,
                    'borderline_high_min' => 130,
                    'needs_control_high_min' => 180,
                    'critical_high_min' => 500,
                    'unit' => 'Ед/л',
                    'display_precision' => 0,
                    'note' => 'Male adult ALP scoring. Conservative fallback; ALP depends on age, bone turnover, liver/bile duct context and lab method. Interpret with GGT and bilirubin.',
                ],
                'female-adult' => [
                    'direction' => 'range',
                    'critical_low_max' => null,
                    'needs_control_low_max' => 25,
                    'borderline_low_max' => 34,
                    'optimal_min' => 35,
                    'optimal_max' => 104,
                    'exceptional_min' => null,
                    'exceptional_max' => null,
                    'borderline_high_min' => 105,
                    'needs_control_high_min' => 160,
                    'critical_high_min' => 500,
                    'unit' => 'Ед/л',
                    'display_precision' => 0,
                    'note' => 'Female adult ALP scoring outside pregnancy. Conservative fallback; ALP changes with pregnancy, age, bone turnover, liver/bile duct context and lab method. Interpret with GGT and bilirubin.',
                ],
            ],

            /*
            |--------------------------------------------------------------------------
            | Sex hormones / binding proteins
            |--------------------------------------------------------------------------
            */

            'testosterone-total' => [
                'male-adult' => [
                    'direction' => 'range',
                    'critical_low_max' => 5.0,
                    'needs_control_low_max' => 8.0,
                    'borderline_low_max' => 11.9,
                    'optimal_min' => 12.0,
                    'optimal_max' => 30.0,
                    'exceptional_min' => null,
                    'exceptional_max' => null,
                    'borderline_high_min' => 30.1,
                    'needs_control_high_min' => 40.0,
                    'critical_high_min' => 60.0,
                    'unit' => 'нмоль/л',
                    'display_precision' => 1,
                    'note' => 'Male adult total testosterone scoring. Morning measurement, age, SHBG, obesity, medications and assay method are important; free testosterone may be needed when SHBG is abnormal.',
                ],
                'female-adult' => [
                    'direction' => 'range',
                    'critical_low_max' => null,
                    'needs_control_low_max' => null,
                    'borderline_low_max' => 0.25,
                    'optimal_min' => 0.26,
                    'optimal_max' => 2.4,
                    'exceptional_min' => null,
                    'exceptional_max' => null,
                    'borderline_high_min' => 2.41,
                    'needs_control_high_min' => 3.5,
                    'critical_high_min' => 7.0,
                    'unit' => 'нмоль/л',
                    'display_precision' => 2,
                    'note' => 'Female adult total testosterone scoring outside pregnancy. Conservative fallback for hyperandrogenism screening context; age, cycle context, PCOS symptoms, medications and assay method matter.',
                ],
            ],

            'prolactin' => [
                'male-adult' => [
                    'direction' => 'range',
                    'critical_low_max' => null,
                    'needs_control_low_max' => null,
                    'borderline_low_max' => 80,
                    'optimal_min' => 81,
                    'optimal_max' => 320,
                    'exceptional_min' => null,
                    'exceptional_max' => null,
                    'borderline_high_min' => 321,
                    'needs_control_high_min' => 500,
                    'critical_high_min' => 2000,
                    'unit' => 'мМЕ/л',
                    'display_precision' => 0,
                    'note' => 'Male adult prolactin scoring. Stress, sleep, macroprolactin, medications and pituitary context matter; repeat testing is often needed before interpretation.',
                ],
                'female-adult' => [
                    'direction' => 'range',
                    'critical_low_max' => null,
                    'needs_control_low_max' => null,
                    'borderline_low_max' => 100,
                    'optimal_min' => 101,
                    'optimal_max' => 500,
                    'exceptional_min' => null,
                    'exceptional_max' => null,
                    'borderline_high_min' => 501,
                    'needs_control_high_min' => 700,
                    'critical_high_min' => 2000,
                    'unit' => 'мМЕ/л',
                    'display_precision' => 0,
                    'note' => 'Female adult prolactin scoring outside pregnancy and lactation. Stress, sleep, macroprolactin, medications, cycle context and pituitary context matter; repeat testing is often needed.',
                ],
            ],

            'shbg' => [
                'male-adult' => [
                    'direction' => 'range',
                    'critical_low_max' => 5,
                    'needs_control_low_max' => 9,
                    'borderline_low_max' => 12,
                    'optimal_min' => 13,
                    'optimal_max' => 70,
                    'exceptional_min' => null,
                    'exceptional_max' => null,
                    'borderline_high_min' => 71,
                    'needs_control_high_min' => 100,
                    'critical_high_min' => 150,
                    'unit' => 'нмоль/л',
                    'display_precision' => 0,
                    'note' => 'Male adult SHBG scoring. SHBG changes free hormone availability and is affected by age, thyroid status, liver status, obesity, insulin resistance and medications.',
                ],
                'female-adult' => [
                    'direction' => 'range',
                    'critical_low_max' => 10,
                    'needs_control_low_max' => 17,
                    'borderline_low_max' => 25,
                    'optimal_min' => 26,
                    'optimal_max' => 120,
                    'exceptional_min' => null,
                    'exceptional_max' => null,
                    'borderline_high_min' => 121,
                    'needs_control_high_min' => 170,
                    'critical_high_min' => 250,
                    'unit' => 'нмоль/л',
                    'display_precision' => 0,
                    'note' => 'Female adult SHBG scoring outside pregnancy. Estrogen therapy, oral contraceptives, thyroid status, liver status, insulin resistance and medications can strongly change SHBG.',
                ],
            ],
        ];

        foreach ($sexAdultRulesV2 as $markerSlug => $rulesByProfile) {

            $marker = Marker::where('slug', $markerSlug)->first();

            if (!$marker) {
                continue;
            }

            foreach ($rulesByProfile as $profileSlug => $rule) {

                $profile = $sexAdultProfilesV2[$profileSlug] ?? null;

                if (!$profile) {
                    continue;
                }

                MarkerScoringRule::updateOrCreate(
                    [
                        'marker_id' => $marker->id,
                        'scoring_profile_id' => $profile->id,
                    ],
                    [
                        'direction' => $rule['direction'],

                        'critical_low_max' => $rule['critical_low_max'],
                        'needs_control_low_max' => $rule['needs_control_low_max'],
                        'borderline_low_max' => $rule['borderline_low_max'],

                        'optimal_min' => $rule['optimal_min'],
                        'optimal_max' => $rule['optimal_max'],

                        'exceptional_min' => $rule['exceptional_min'],
                        'exceptional_max' => $rule['exceptional_max'],

                        'borderline_high_min' => $rule['borderline_high_min'],
                        'needs_control_high_min' => $rule['needs_control_high_min'],
                        'critical_high_min' => $rule['critical_high_min'],

                        'unit' => $rule['unit'],

                        'display_precision' => $rule['display_precision'],
                        'zone_mode' => 'bands',
                        'health_direction' => match ($rule['direction']) {
                            'higher_better' => 'higher_is_better',
                            'lower_better' => 'lower_is_better',
                            default => 'range_is_better',
                        },

                        'source' => 'DSlog sex-specific adult scoring quality pack v2; conservative fallback; lab-specific reference intervals and clinical context must override',
                        'note' => $rule['note'],

                        'is_active' => true,
                    ]
                );
            }
        }
    



    
    
    
    
    
    
    
    
    }
}
