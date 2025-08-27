<style>
        .search-section,
        .job-results-section {
            margin-bottom: 2rem;
        }

        .search-wrap {
            background: linear-gradient(180deg, #ffffff 0%, #f8fbff 100%);
            border: 2px solid #2b6fdb !important;
            transition: all 0.3s ease;
        }

        .search-wrap:hover {
            box-shadow: 0 8px 24px rgba(43, 111, 219, 0.2);
        }

        /* Section Titles and Dividers */
        .section-title {
            font-size: 1.1rem;
            color: #2b6fdb;
            font-weight: 600;
            border-left: 4px solid #2b6fdb;
            padding-left: 1rem;
            transition: all 0.3s ease;
        }

        .section-title:hover {
            color: #1f5fd1;
            transform: translateX(4px);
        }

        .section-divider {
            height: 2px;
            background: linear-gradient(to right, transparent, #2b6fdb, transparent);
            margin: 1.5rem 0;
            opacity: 0.7;
        }

        /* Quick Search Row */
        .quick-row .form-control,
        .quick-row .form-select {
            height: 46px;
            border-radius: 50px;
            transition: border-color 0.3s ease, box-shadow 0.3s ease, transform 0.2s ease;
        }

        .quick-row .form-control:focus,
        .quick-row .form-select:focus {
            border-color: #2b6fdb;
            box-shadow: 0 0 0 0.2rem rgba(43, 111, 219, 0.25);
            transform: scale(1.02);
        }

        .quick-row .input-group-text {
            background: #f8f9fa;
            border: 1px solid #ced4da;
            border-right: none;
            border-radius: 50px 0 0 50px;
        }

        .quick-row .form-control {
            border: 1px solid #ced4da;
            border-radius: 0 50px 50px 0;
        }

        .quick-row .btn {
            height: 46px;
            font-size: 0.95rem;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .quick-row .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(43, 111, 219, 0.3);
        }

        /* Advanced Filters */
        .filter-adv .form-select,
        .filter-adv .form-control {
            height: 42px;
            border-radius: 50px;
            transition: border-color 0.3s ease, box-shadow 0.3s ease, transform 0.2s ease;
        }

        .filter-adv .form-select:focus,
        .filter-adv .form-control:focus {
            border-color: #2b6fdb;
            box-shadow: 0 0 0 0.2rem rgba(43, 111, 219, 0.25);
            transform: scale(1.02);
        }

        .filter-adv .form-control-sm {
            height: 38px;
            min-width: 100px;
        }

        .filter-adv .form-check {
            margin-top: 0;
            display: flex;
            align-items: center;
        }

        .salary-filter-wrap {
            flex-wrap: nowrap;
            background: #f8fbff;
            padding: 0.5rem 1rem;
            border-radius: 12px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
        }

        .salary-filter-wrap:hover {
            background: #e9f2ff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .salary-filter-wrap .form-control-sm {
            flex: 1;
            min-width: 80px;
        }

        .salary-filter-wrap .btn {
            padding: 0.5rem 1rem;
            font-size: 0.85rem;
            line-height: 1;
        }

        .salary-filter-wrap .text-muted {
            font-size: 0.9rem;
            flex: 0 0 auto;
        }

        .salary-filter-wrap .form-check-input {
            margin-top: 0;
        }

        .salary-filter-wrap .form-check-label {
            font-size: 0.9rem;
        }

        /* Filter Sections and Dividers */
        .filter-section {
            position: relative;
            padding: 1.5rem;
            background: #fff;
            border-radius: 8px;
            transition: all 0.3s ease;
        }

        .filter-section:hover {
            background: #f8fbff;
            box-shadow: 0 4px 12px rgba(43, 111, 219, 0.1);
            transform: translateY(-2px);
        }

        .filter-divider {
            height: 2px;
            background: linear-gradient(to right, transparent, #2b6fdb, transparent);
            margin: 1.5rem 0;
            opacity: 0.7;
        }

        .filter-header {
            position: relative;
            padding-left: 1.5rem;
            transition: all 0.3s ease;
        }

        .filter-header::before {
            content: '';
            position: absolute;
            left: 0;
            top: 50%;
            transform: translateY(-50%);
            width: 4px;
            height: 1.5rem;
            background: #2b6fdb;
            border-radius: 2px;
            transition: height 0.3s ease;
        }

        .filter-section:hover .filter-header::before {
            height: 2rem;
        }

        /* Pills */
        .pill {
            border: 1px solid #d7e3ff;
            background: #f8fbff;
            color: #2b6fdb;
            border-radius: 999px;
            padding: 0.5rem 1.2rem;
            font-size: 0.9rem;
            cursor: pointer;
            transition: all 0.2s ease, transform 0.2s ease;
            flex: 0 1 auto;
            white-space: nowrap;
        }

        .btn-check:checked+.pill {
            background: #2b6fdb;
            border-color: #2b6fdb;
            color: #fff;
            font-weight: 500;
            transform: scale(1.05);
        }

        .pill:hover {
            background: #e9f2ff;
            border-color: #9dc2ff;
            transform: scale(1.05);
        }

        /* Skill Chips */
        .skills-chip-wrap {
            display: flex;
            flex-wrap: wrap;
            gap: 0.5rem;
            padding: 0.5rem 0;
        }

        .chip-check {
            border: 1px solid #d7e3ff;
            background: #f8fbff;
            color: #2b6fdb;
            border-radius: 999px;
            padding: 0.5rem 1.2rem;
            font-size: 0.9rem;
            cursor: pointer;
            transition: all 0.2s ease, transform 0.2s ease;
            flex: 0 1 auto;
            white-space: nowrap;
        }

        .btn-check:checked+.chip-check {
            background: #2b6fdb;
            border-color: #2b6fdb;
            color: #fff;
            font-weight: 500;
            transform: scale(1.05);
        }

        .chip-check.chip-clear {
            border-style: dashed;
            color: #6b7280;
            background: #fff;
        }

        .chip-check:hover {
            background: #e9f2ff;
            border-color: #9dc2ff;
            transform: scale(1.05);
        }

        /* Filter Buttons */
        .filter-btn,
        .filter-toggle {
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .filter-btn:hover,
        .filter-toggle:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(43, 111, 219, 0.3);
        }

        /* Job Cards and Rows */
        .chips-scroll {
            display: flex;
            gap: 0.5rem;
            overflow: auto hidden;
            white-space: nowrap;
            padding-bottom: 0.3rem;
        }

        .chip-mini {
            display: inline-flex;
            align-items: center;
            padding: 0.3rem 0.7rem;
            border-radius: 999px;
            background: #eef4ff;
            border: 1px solid #d7e3ff;
            font-size: 0.85rem;
            transition: all 0.2s ease;
        }

        .chip-mini:hover {
            background: #d7e3ff;
        }

        .chip-mini.more {
            background: #f6f6f6;
            border-color: #e4e4e4;
            color: #666;
        }

        .job-card,
        .job-row {
            background: #fff;
            border: 2px solid #28a745 !important;
            overflow: hidden;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .job-card:hover,
        .job-row:hover {
            box-shadow: 0 12px 30px rgba(40, 167, 69, 0.2);
            transform: translateY(-6px);
        }

        .job-card-img:hover {
            transform: scale(1.05);
        }

        .job-title a:hover {
            color: #2b6fdb;
        }

        .salary-display {
            display: inline-block;
            background: #28a745;
            /* hoặc bg-success */
            color: #fff;
            padding: 2px 8px;
            /* thu nhỏ padding */
            border-radius: 8px;
            /* bo tròn nhẹ hơn */
            font-size: 0.8rem;
            /* chữ nhỏ lại */
            font-weight: 500;
            /* chữ vừa, không quá bold */
            line-height: 1.2;
        }

        .salary-display .bi {
            font-size: 0.9rem;
            /* icon nhỏ theo chữ */
            margin-right: 4px;
        }


        .salary-display:hover {
            background: linear-gradient(135deg, #23963d 0%, #2db74f 100%);
            box-shadow: 0 5px 15px rgba(40, 167, 69, 0.3);
            transform: scale(1.05);
        }

        .salary-text {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .job-type-badge {
            background: #e9f2ff;
            color: #2b6fdb;
            font-weight: 600;
            border-radius: 999px;
            padding: 0.3rem 0.8rem;
            font-size: 0.85rem;
            transition: all 0.2s ease;
        }

        .job-type-badge:hover {
            background: #d7e3ff;
        }

        .badge-hot {
            background: linear-gradient(90deg, #ff7e00, #ff3d00);
            color: #fff;
            font-weight: 600;
            border-radius: 999px;
            padding: 5px 14px;
            font-size: 0.8rem;
            box-shadow: 0 0 12px rgba(255, 100, 0, 0.5);
            transition: all 0.2s ease;
        }

        .badge-top {
            background: #28a745;
            color: #fff;
            font-weight: 600;
            border-radius: 999px;
            padding: 5px 14px;
            font-size: 0.8rem;
            box-shadow: 0 0 8px rgba(40, 167, 69, 0.4);
            transition: all 0.2s ease;
        }

        .badge-hot:hover,
        .badge-top:hover {
            opacity: 0.9;
        }

        /* Buttons */
        .btn-primary {
            background: #2b6fdb;
            border: none;
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            background: #1f5fd1;
            box-shadow: 0 4px 12px rgba(43, 111, 219, 0.3);
        }

        .btn-outline-primary {
            border-color: #2b6fdb;
            color: #2b6fdb;
            transition: all 0.3s ease;
        }

        .btn-outline-primary:hover {
            background: #e9f2ff;
            border-color: #1f5fd1;
            color: #1f5fd1;
        }

        .btn-outline-secondary {
            border-color: #6b7280;
            color: #6b7280;
            transition: all 0.3s ease;
        }

        .btn-outline-secondary:hover {
            background: #f8f9fa;
            border-color: #2b6fdb;
            color: #2b6fdb;
        }

        .btn-light {
            border-color: #e9ecef;
            background: #f8f9fa;
            transition: all 0.3s ease;
        }

        .btn-light:hover {
            background: #e9ecef;
            border-color: #d7e3ff;
            color: #2b6fdb;
        }

        /* Mobile Responsiveness */
        @media (max-width: 576px) {

            .search-section,
            .job-results-section {
                margin-bottom: 1.5rem;
            }

            .quick-row .form-control,
            .quick-row .form-select,
            .quick-row .btn {
                height: 40px;
                font-size: 0.9rem;
            }

            .quick-row .input-group-text {
                border-radius: 12px 0 0 12px;
            }

            .quick-row .form-control {
                border-radius: 0 12px 12px 0;
            }

            .filter-adv .form-select,
            .filter-adv .form-control {
                height: 38px;
            }

            .filter-adv .form-control-sm {
                height: 34px;
                min-width: 80px;
            }

            .salary-filter-wrap {
                flex-wrap: wrap;
                gap: 0.5rem;
                padding: 0.75rem;
            }

            .salary-filter-wrap .form-check {
                width: 100%;
            }

            .pill,
            .chip-check {
                padding: 0.4rem 1rem;
                font-size: 0.85rem;
            }

            .section-divider,
            .filter-divider {
                margin: 1rem 0;
                height: 1px;
            }

            .section-title {
                font-size: 1rem;
            }

            .filter-section {
                padding: 1rem;
            }

            .filter-header::before {
                height: 1.2rem;
            }

            .filter-section:hover .filter-header::before {
                height: 1.5rem;
            }

            .job-card,
            .job-row {
                padding: 1rem !important;
            }

            .job-title {
                font-size: 1.1rem;
            }

            .job-card-img {
                height: 140px !important;
            }

            .salary-display {
                font-size: 0.85rem;
                padding: 0.3rem 0.8rem;
            }

            .row.g-5 {
                --bs-gutter-x: 1.5rem;
            }

            .vstack.gap-5 {
                --bs-gutter-y: 1.5rem;
            }
        }
    </style>