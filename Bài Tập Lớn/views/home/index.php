<?php
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OnlineCourse - Học Lập Trình Trực Tuyến</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick-theme.min.css">
    <style>
        :root {
            --primary-color: #2563eb;
            --secondary-color: #7c3aed;
            --accent-color: #dc2626;
            --success-color: #059669;
            --warning-color: #d97706;
            --danger-color: #dc2626;
            --info-color: #0891b2;
            --text-color: #111827;
            --light-gray: #f9fafb;
            --border-color: #e5e7eb;
            --dark-blue: #1e3a8a;
            --gradient-1: linear-gradient(135deg, #1e40af 0%, #7c3aed 100%);
            --gradient-2: linear-gradient(135deg, #dc2626 0%, #f97316 100%);
            --gradient-3: linear-gradient(135deg, #0891b2 0%, #06b6d4 100%);
            --gradient-4: linear-gradient(135deg, #059669 0%, #10b981 100%);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            color: var(--text-color);
            line-height: 1.6;
            overflow-x: hidden;
        }

        /* Header Styles */
        .header-top {
            background-color: #f8fafc;
            border-bottom: 1px solid #e2e8f0;
            padding: 8px 0;
        }

        .header-main {
            background-color: #ffffff;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1), 0 1px 2px rgba(0,0,0,0.06);
            position: sticky;
            top: 0;
            z-index: 1000;
        }

        .navbar-brand {
            font-weight: 700;
            font-size: 1.5rem;
            color: var(--primary-color) !important;
            display: flex;
            align-items: center;
        }

        .navbar-brand i {
            margin-right: 8px;
        }

        .nav-link {
            font-weight: 500;
            color: #6c757d !important;
            padding: 0.5rem 1rem !important;
            transition: color 0.3s ease;
            position: relative;
        }

        .nav-link:hover {
            color: var(--primary-color) !important;
        }

        .nav-link.active {
            color: var(--primary-color) !important;
        }

        /* Navigation Indicator Bar */
        .nav-indicator {
            position: absolute;
            bottom: 0;
            height: 3px;
            background-color: var(--primary-color);
            border-radius: 2px;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            z-index: 10;
        }

        .search-box {
            position: relative;
            max-width: 400px;
        }

        .search-box input {
            border-radius: 20px;
            padding-left: 40px;
            border: 1px solid var(--border-color);
            transition: all 0.3s ease;
        }

        .search-box input:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(0, 86, 210, 0.1);
        }

        .search-box i {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #6c757d;
        }

        .btn-primary {
            background-color: var(--primary-color);
            border: none;
            padding: 0.5rem 1.5rem;
            border-radius: 4px;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            background-color: var(--secondary-color);
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(0, 86, 210, 0.3);
        }

        .btn-outline-primary {
            color: var(--primary-color);
            border-color: var(--primary-color);
            font-weight: 500;
        }

        .btn-outline-primary:hover {
            background-color: var(--primary-color);
            color: white;
            transform: translateY(-1px);
        }

        /* Hero Section */
        .hero-section {
            background: linear-gradient(135deg, #1e40af 0%, #7c3aed 100%);
            padding: 80px 0;
            position: relative;
            overflow: hidden;
        }

        .hero-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320"><path fill="%23ffffff" fill-opacity="0.15" d="M0,96L48,112C96,128,192,160,288,160C384,160,480,128,576,112C672,96,768,96,864,112C960,128,1056,160,1152,160C1248,160,1344,128,1392,112L1440,96L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z"></path></svg>') no-repeat bottom;
            background-size: cover;
        }

        .hero-content {
            position: relative;
            z-index: 2;
        }

        .hero-title {
            font-size: 3.5rem;
            font-weight: 700;
            color: white;
            margin-bottom: 1.5rem;
            line-height: 1.2;
        }

        .hero-subtitle {
            font-size: 1.3rem;
            color: rgba(255, 255, 255, 0.9);
            margin-bottom: 2.5rem;
            max-width: 600px;
        }

        .hero-buttons {
            display: flex;
            gap: 1rem;
            flex-wrap: wrap;
        }

        .hero-image {
            position: relative;
            z-index: 2;
        }

        .hero-image img {
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.2);
        }

        /* New Colorful Styles */
        .text-gradient {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .text-gradient-secondary {
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .bg-gradient {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }

        .btn-gradient {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            border-radius: 50px;
            font-weight: 600;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);
        }

        .btn-gradient:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(102, 126, 234, 0.6);
            color: white;
        }

        .btn-outline-gradient {
            background: transparent;
            color: white;
            border: 2px solid rgba(255, 255, 255, 0.8);
            border-radius: 50px;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-outline-gradient:hover {
            background: rgba(255, 255, 255, 0.1);
            border-color: white;
            color: white;
            transform: translateY(-2px);
        }

        .hero-stats {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border-radius: 15px;
            padding: 1.5rem;
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .stat-item {
            text-align: center;
            color: white;
        }

        .stat-number {
            font-size: 1.5rem;
            font-weight: 700;
            margin-bottom: 0.25rem;
        }

        .stat-label {
            font-size: 0.875rem;
            opacity: 0.9;
            margin: 0;
        }

        .image-wrapper {
            position: relative;
        }

        .floating-card {
            position: absolute;
            background: white;
            border-radius: 12px;
            padding: 0.75rem 1rem;
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 0.875rem;
            font-weight: 600;
            animation: float 3s ease-in-out infinite;
        }

        .floating-card.card-1 {
            top: 20px;
            right: -30px;
            animation-delay: 0s;
        }

        .floating-card.card-2 {
            bottom: 30px;
            left: -20px;
            animation-delay: 1s;
        }

        .floating-card.card-3 {
            top: 50%;
            right: -40px;
            animation-delay: 2s;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
        }

        /* Features Section */
        .section-title {
            font-size: 2.5rem;
            font-weight: 700;
            color: var(--dark-blue);
            margin-bottom: 1rem;
            text-align: center;
        }

        .section-subtitle {
            font-size: 1.1rem;
            color: #6c757d;
            text-align: center;
            margin-bottom: 3rem;
            max-width: 700px;
            margin-left: auto;
            margin-right: auto;
        }

        .feature-card {
            background: white;
            border-radius: 12px;
            padding: 2.5rem;
            box-shadow: 0 4px 20px rgba(0,0,0,0.08);
            transition: all 0.3s ease;
            height: 100%;
            border: 1px solid var(--border-color);
            position: relative;
            overflow: hidden;
        }

        .feature-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, var(--primary-color), var(--secondary-color));
        }

        .feature-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 12px 40px rgba(0,0,0,0.15);
        }

        .feature-icon {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 1.5rem;
            font-size: 2rem;
            color: white;
        }

        .feature-title {
            font-size: 1.4rem;
            font-weight: 600;
            margin-bottom: 1rem;
            color: var(--dark-blue);
        }

        .feature-text {
            color: #6c757d;
            margin-bottom: 1rem;
            line-height: 1.7;
        }

        .feature-footer {
            margin-top: auto;
            padding-top: 1rem;
        }

        /* Colorful Feature Card Variations */
        .feature-card-1 {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
        }

        .feature-card-1 .feature-title,
        .feature-card-1 .feature-text {
            color: white;
        }

        .feature-card-1::before {
            background: linear-gradient(90deg, #f093fb 0%, #f5576c 100%);
        }

        .feature-card-1 .feature-icon {
            background: rgba(255, 255, 255, 0.2);
            color: white;
        }

        .feature-card-2 {
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            color: white;
            border: none;
        }

        .feature-card-2 .feature-title,
        .feature-card-2 .feature-text {
            color: white;
        }

        .feature-card-2::before {
            background: linear-gradient(90deg, #4facfe 0%, #00f2fe 100%);
        }

        .feature-card-2 .feature-icon {
            background: rgba(255, 255, 255, 0.2);
            color: white;
        }

        .feature-card-3 {
            background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);
            color: white;
            border: none;
        }

        .feature-card-3 .feature-title,
        .feature-card-3 .feature-text {
            color: white;
        }

        .feature-card-3::before {
            background: linear-gradient(90deg, #fa709a 0%, #fee140 100%);
        }

        .feature-card-3 .feature-icon {
            background: rgba(255, 255, 255, 0.2);
            color: white;
        }

        /* Course Cards */
        .course-card {
            background: white;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 20px rgba(0,0,0,0.08);
            transition: all 0.3s ease;
            height: 100%;
            display: flex;
            flex-direction: column;
            border: 1px solid var(--border-color);
        }

        .course-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 40px rgba(0,0,0,0.15);
        }

        .course-card-link {
            text-decoration: none !important;
            color: inherit !important;
        }

        .course-card-link:hover {
            text-decoration: none !important;
            color: inherit !important;
        }

        .instructor-card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.08);
            transition: all 0.3s ease;
            height: 100%;
        }

        .instructor-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 40px rgba(0,0,0,0.15);
        }

        .course-img {
            height: 200px;
            width: 100%;
            object-fit: cover;
            position: relative;
        }

        .course-badge {
            position: absolute;
            top: 10px;
            left: 10px;
            background: var(--primary-color);
            color: white;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 600;
        }

        .course-body {
            padding: 1.5rem;
            flex-grow: 1;
            display: flex;
            flex-direction: column;
        }

        .course-category {
            font-size: 0.8rem;
            color: var(--primary-color);
            font-weight: 600;
            margin-bottom: 0.5rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .course-title {
            font-size: 1.1rem;
            font-weight: 600;
            margin-bottom: 0.75rem;
            color: var(--dark-blue);
            line-height: 1.4;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .course-instructor {
            font-size: 0.9rem;
            color: #6c757d;
            margin-bottom: 1rem;
        }

        .course-meta {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: auto;
            padding-top: 1rem;
            border-top: 1px solid var(--border-color);
        }

        .course-rating {
            display: flex;
            align-items: center;
            gap: 4px;
        }

        .course-rating .stars {
            color: #ffc107;
            font-size: 0.9rem;
        }

        .course-rating .rating-count {
            color: #6c757d;
            font-size: 0.9rem;
            margin-left: 4px;
        }

        .course-price {
            font-weight: 700;
            color: var(--primary-color);
            font-size: 1.2rem;
        }

        .course-price .original-price {
            text-decoration: line-through;
            color: #6c757d;
            font-size: 0.9rem;
            margin-right: 8px;
        }

        /* Categories Section */
        .category-card {
            background: white;
            border-radius: 12px;
            padding: 2rem;
            text-align: center;
            box-shadow: 0 4px 20px rgba(0,0,0,0.08);
            transition: all 0.3s ease;
            height: 100%;
            border: 1px solid var(--border-color);
            cursor: pointer;
        }

        .category-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 40px rgba(0,0,0,0.15);
            border-color: var(--primary-color);
        }

        .category-icon {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.5rem;
            font-size: 2rem;
            color: white;
        }

        .category-title {
            font-size: 1.2rem;
            font-weight: 600;
            margin-bottom: 0.5rem;
            color: var(--dark-blue);
        }

        .category-count {
            color: #6c757d;
            font-size: 0.9rem;
        }

        /* Testimonials */
        .testimonial-card {
            background: white;
            border-radius: 12px;
            padding: 2rem;
            box-shadow: 0 4px 20px rgba(0,0,0,0.08);
            height: 100%;
            border: 1px solid var(--border-color);
            position: relative;
        }

        .testimonial-card::before {
            content: '\201C';
            font-size: 4rem;
            color: var(--primary-color);
            opacity: 0.2;
            position: absolute;
            top: 1rem;
            left: 1.5rem;
            font-family: Georgia, serif;
        }

        .testimonial-text {
            font-style: italic;
            color: #495057;
            margin-bottom: 1.5rem;
            line-height: 1.7;
            position: relative;
            z-index: 1;
        }

        .testimonial-author {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .testimonial-avatar {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            object-fit: cover;
            border: 3px solid var(--primary-color);
        }

        .testimonial-info h5 {
            margin-bottom: 0.25rem;
            font-size: 1rem;
            color: var(--dark-blue);
        }

        .testimonial-info p {
            margin-bottom: 0;
            font-size: 0.9rem;
            color: #6c757d;
        }

        .testimonial-rating {
            margin-top: 1rem;
            color: #ffc107;
        }

        /* Stats Section */
        .stats-section {
            background: linear-gradient(135deg, #1e3a8a 0%, #2563eb 100%);
            padding: 80px 0;
            position: relative;
            overflow: hidden;
        }

        .stats-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320"><path fill="%23ffffff" fill-opacity="0.1" d="M0,96L48,112C96,128,192,160,288,160C384,160,480,128,576,112C672,96,768,96,864,112C960,128,1056,160,1152,160C1248,160,1344,128,1392,112L1440,96L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z"></path></svg>') no-repeat bottom;
            background-size: cover;
        }

        .stat-card {
            text-align: center;
            color: white;
            position: relative;
            z-index: 2;
        }

        .stat-number {
            font-size: 3rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
        }

        .stat-label {
            font-size: 1.1rem;
            opacity: 0.9;
        }

        /* CTA Section */
        .cta-section {
            background: linear-gradient(135deg, #dc2626 0%, #f97316 100%);
            padding: 80px 0;
            text-align: center;
            color: white;
            position: relative;
            overflow: hidden;
        }

        .cta-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320"><path fill="%23ffffff" fill-opacity="0.1" d="M0,96L48,112C96,128,192,160,288,160C384,160,480,128,576,112C672,96,768,96,864,112C960,128,1056,160,1152,160C1248,160,1344,128,1392,112L1440,96L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z"></path></svg>') no-repeat bottom;
            background-size: cover;
        }

        .cta-content {
            position: relative;
            z-index: 2;
        }

        .cta-title {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 1.5rem;
        }

        .cta-text {
            font-size: 1.2rem;
            margin-bottom: 2.5rem;
            opacity: 0.9;
            max-width: 600px;
            margin-left: auto;
            margin-right: auto;
        }

        .btn-light {
            background-color: white;
            color: var(--primary-color);
            font-weight: 600;
            padding: 0.75rem 2rem;
            border-radius: 4px;
            transition: all 0.3s ease;
            border: none;
        }

        .btn-light:hover {
            background-color: #f8f9fa;
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(0,0,0,0.2);
        }

        /* Footer */
        footer {
            background-color: #111827;
            color: white;
            padding: 60px 0 30px;
        }

        .footer-logo {
            font-size: 1.5rem;
            font-weight: 700;
            color: white;
            margin-bottom: 1.5rem;
            display: inline-block;
        }

        .footer-about {
            color: #bdc3c7;
            margin-bottom: 1.5rem;
            line-height: 1.7;
        }

        .social-links {
            display: flex;
            gap: 1rem;
            margin-top: 1.5rem;
        }

        .social-link {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background-color: rgba(255,255,255,0.1);
            color: white;
            transition: all 0.3s ease;
            text-decoration: none;
        }

        .social-link:hover {
            background-color: var(--primary-color);
            color: white;
            transform: translateY(-3px);
        }

        .footer-title {
            font-size: 1.2rem;
            font-weight: 600;
            color: white;
            margin-bottom: 1.5rem;
            position: relative;
            padding-bottom: 0.75rem;
        }

        .footer-title::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 40px;
            height: 3px;
            background-color: var(--primary-color);
            border-radius: 2px;
        }

        /* Footer Links Reset */
        footer a {
            color: #9ca3af !important;
            text-decoration: none !important;
        }
        
        footer a:hover {
            color: #60a5fa !important;
        }

        .footer-links {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .footer-links li {
            margin-bottom: 0.75rem;
        }

        .footer-links a,
        .footer-links a:link,
        .footer-links a:visited,
        .footer-links a:focus,
        .footer-links a:active {
            color: #9ca3af !important;
            text-decoration: none !important;
            transition: all 0.3s ease;
            display: block;
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none;
        }

        .footer-links a:hover,
        .footer-links a:visited:hover {
            color: #60a5fa !important;
            transform: translateX(3px);
            transition: all 0.3s ease;
        }

        .footer-contact p {
            display: flex;
            align-items: flex-start;
            margin-bottom: 1rem;
            color: #bdc3c7;
        }

        .footer-contact i {
            margin-right: 1rem;
            color: var(--primary-color);
            margin-top: 4px;
            width: 20px;
        }

        .footer-bottom {
            border-top: 1px solid rgba(255,255,255,0.1);
            padding-top: 2rem;
            margin-top: 3rem;
            text-align: center;
            color: #bdc3c7;
            font-size: 0.9rem;
        }

        /* Responsive Design */
        @media (max-width: 991.98px) {
            .hero-title {
                font-size: 2.8rem;
            }
            
            .section-title {
                font-size: 2rem;
            }
            
            .search-box {
                max-width: 100%;
                margin: 1rem 0;
            }
        }

        @media (max-width: 767.98px) {
            .hero-section {
                padding: 60px 0;
                text-align: center;
            }
            
            .hero-title {
                font-size: 2.2rem;
            }
            
            .hero-subtitle {
                font-size: 1.1rem;
            }
            
            .hero-buttons {
                justify-content: center;
            }
            
            .hero-buttons .btn {
                width: 100%;
                max-width: 250px;
            }
            
            .section-title {
                font-size: 1.8rem;
            }
            
            .feature-card, .testimonial-card {
                margin-bottom: 1.5rem;
            }
            
            .stat-number {
                font-size: 2.5rem;
            }
            
            .cta-title {
                font-size: 2rem;
            }
        }

        @media (max-width: 575.98px) {
            .hero-title {
                font-size: 1.8rem;
            }
            
            .hero-subtitle {
                font-size: 1rem;
            }
            
            .section-title {
                font-size: 1.5rem;
            }
            
            .feature-card, .category-card {
                padding: 1.5rem;
            }
        }

        /* Loading Animation */
        .skeleton {
            background: linear-gradient(90deg, #f0f0f0 25%, #e0e0e0 50%, #f0f0f0 75%);
            background-size: 200% 100%;
            animation: loading 1.5s infinite;
        }

        @keyframes loading {
            0% {
                background-position: 200% 0;
            }
            100% {
                background-position: -200% 0;
            }
        }

        /* Fade In Animation */
        .fade-in {
            opacity: 0;
            transform: translateY(30px);
            transition: all 0.6s ease;
        }

        .fade-in.visible {
            opacity: 1;
            transform: translateY(0);
        }

        /* Custom Scrollbar */
        ::-webkit-scrollbar {
            width: 10px;
        }

        ::-webkit-scrollbar-track {
            background: #f1f1f1;
        }

        ::-webkit-scrollbar-thumb {
            background: var(--primary-color);
            border-radius: 5px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: var(--secondary-color);
        }
    </style>
</head>
<body>
    <!-- Top Header -->
    <div class="header-top">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <div class="d-flex align-items-center gap-3">
                        <span class="text-muted"><i class="fas fa-phone"></i>0342381276</span>
                        <span class="text-muted"><i class="fas fa-envelope"></i> quangnguyenvan2k5@gmail.com</span>
                    </div>
                </div>
                <div class="col-md-6 text-md-end">
                    <div class="d-flex align-items-center justify-content-md-end gap-3">
                        <a href="https://www.facebook.com/quang.nguyen.490818/" class="text-muted" target="_blank"><i class="fab fa-facebook"></i></a>
                        <a href="https://www.instagram.com/wang_uen/" class="text-muted" target="_blank"><i class="fab fa-instagram"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Header -->
    <header class="header-main">
        <nav class="navbar navbar-expand-lg navbar-light">
            <div class="container">
                <a class="navbar-brand" href="#">
                    <i class="fas fa-graduation-cap"></i>
                    OnlineCourse
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav me-auto position-relative">
                        <li class="nav-item">
                            <a class="nav-link active" href="#home">Trang chủ</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#courses">Khóa học</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#categories">Danh mục</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#about">Về chúng tôi</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#testimonials">Đánh giá</a>
                        </li>
                        <div class="nav-indicator"></div>
                    </ul>
                    <div class="d-flex align-items-center">
                        <div class="search-box me-3">
                            <form method="GET" action="/onlinecourse/onlinecourse/index.php" style="display: flex; align-items: center;">
                                <input type="hidden" name="controller" value="Course">
                                <input type="hidden" name="action" value="index">
                                <i class="fas fa-search"></i>
                                <input type="text" class="form-control" name="keyword" placeholder="Tìm kiếm khóa học..." style="border: none; background: transparent;">
                            </form>
                        </div>
                        <?php if (!empty($_SESSION['user_id'])): ?>
                            <?php $role = (int)($_SESSION['user_role'] ?? 0); ?>
                            
                            <?php if ($role === 0): ?>
                                <a href="/onlinecourse/onlinecourse/index.php?controller=Enrollment&action=myCourses" class="btn btn-outline-primary me-2">
                                    <i class="fas fa-book"></i> Khóa học của tôi
                                </a>
                            <?php elseif ($role === 1): ?>
                                <a href="/onlinecourse/onlinecourse/index.php?controller=Instructor&action=dashboard" class="btn btn-outline-primary me-2">
                                    <i class="fas fa-chalkboard-teacher"></i> Giảng viên
                                </a>
                            <?php elseif ($role === 2): ?>
                                <a href="/onlinecourse/onlinecourse/index.php?controller=Admin&action=dashboard" class="btn btn-outline-primary me-2">
                                    <i class="fas fa-cog"></i> Quản trị
                                </a>
                            <?php endif; ?>
                            
                            <div class="dropdown">
                                <a class="btn btn-link text-decoration-none dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                                    <i class="fas fa-user-circle"></i> 
                                    <?= htmlspecialchars($_SESSION['user_name'] ?? 'User') ?>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end">
                                    <li><a class="dropdown-item" href="/onlinecourse/onlinecourse/index.php?controller=Auth&action=profile"><i class="fas fa-user"></i> Hồ sơ cá nhân</a></li>
                                    <li><a class="dropdown-item" href="/onlinecourse/onlinecourse/index.php?controller=Auth&action=profile#password-tab"><i class="fas fa-key"></i> Đổi mật khẩu</a></li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li><a class="dropdown-item" href="/onlinecourse/onlinecourse/index.php?controller=Auth&action=logout">
                                        <i class="fas fa-sign-out-alt"></i> Đăng xuất
                                    </a></li>
                                </ul>
                            </div>
                        <?php else: ?>
                            <a href="/onlinecourse/onlinecourse/index.php?controller=Auth&action=login" class="btn btn-outline-primary me-2">Đăng nhập</a>
                            <a href="/onlinecourse/onlinecourse/index.php?controller=Auth&action=register" class="btn btn-primary">Đăng ký</a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </nav>
    </header>

    <!-- Hero Section -->
    <section class="hero-section" id="home">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <div class="hero-content">
                        <div class="badge bg-gradient text-white mb-3 px-3 py-2">
                            <i class="fas fa-star me-2"></i>Top 1 Platform 2025
                        </div>
                        <h1 class="hero-title">
                            <span class="text-gradient">Học Lập Trình</span><br>
                            <span class="text-gradient-secondary">Trực Tuyến</span>
                        </h1>
                        <p class="hero-subtitle">
                            Khám phá các khóa học lập trình chất lượng cao, 
                            được thiết kế bởi các chuyên gia hàng đầu trong ngành công nghệ thông tin.
                        </p>
                        <div class="hero-buttons">
                            <a href="#courses" class="btn btn-gradient btn-lg px-4 py-3">
                                <i class="fas fa-search me-2"></i> Khám phá khóa học
                            </a>
                            <a href="https://youtu.be/oTQPxPFROck" target="_blank" class="btn btn-outline-gradient btn-lg px-4 py-3">
                                <i class="fas fa-play-circle me-2"></i> Xem giới thiệu
                            </a>
                        </div>
                        <div class="hero-stats mt-4">
                            <div class="row g-3">
                                <div class="col-4">
                                    <div class="stat-item">
                                        <h3 class="stat-number">5000</h3>
                                        <p class="stat-label">Học viên</p>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="stat-item">
                                        <h3 class="stat-number">100+</h3>
                                        <p class="stat-label">Khóa học</p>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="stat-item">
                                        <h3 class="stat-number">95%</h3>
                                        <p class="stat-label">Hài lòng</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="hero-image">
                        <div class="image-wrapper">
                            <img src="https://images.unsplash.com/photo-1516321318423-f06f85e504b3?ixlib=rb-1.2.1&auto=format&fit=crop&w=1000&q=80" 
                                 alt="Học lập trình" class="img-fluid rounded-4 shadow-lg">
                            <div class="floating-card card-1">
                                <div class="card-body">
                                    <i class="fas fa-code text-primary"></i>
                                    <span>Web Development</span>
                                </div>
                            </div>
                            <div class="floating-card card-2">
                                <div class="card-body">
                                    <i class="fas fa-mobile-alt text-success"></i>
                                    <span>Mobile Apps</span>
                                </div>
                            </div>
                            <div class="floating-card card-3">
                                <div class="card-body">
                                    <i class="fas fa-brain text-warning"></i>
                                    <span>AI & ML</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="py-5" id="about">
        <div class="container">
            <h2 class="section-title">Tại sao chọn OnlineCourse?</h2>
            <p class="section-subtitle">
                Chúng tôi mang đến trải nghiệm học tập tốt nhất cho bạn
            </p>
            <div class="row g-4">
                <div class="col-lg-4 col-md-6">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-graduation-cap"></i>
                        </div>
                        <h3 class="feature-title">Giảng viên chất lượng</h3>
                        <p class="feature-text">Đội ngũ giảng viên giàu kinh nghiệm, chuyên môn cao và tâm huyết với nghề.</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-clock"></i>
                        </div>
                        <h3 class="feature-title">Linh hoạt thời gian</h3>
                        <p class="feature-text">Học mọi lúc, mọi nơi với thời gian linh hoạt phù hợp với lịch trình của bạn.</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-certificate"></i>
                        </div>
                        <h3 class="feature-title">Chứng nhận giá trị</h3>
                        <p class="feature-text">Nhận chứng chỉ được công nhận sau khi hoàn thành khóa học.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Popular Courses -->
    <section class="py-5 bg-light" id="courses">
        <div class="container">
            <div class="row mb-4">
                <div class="col-12">
                    <h2 class="section-title">Khóa học nổi bật</h2>
                    <p class="section-subtitle">
                        Các khóa học được nhiều học viên quan tâm và đánh giá cao
                    </p>
                </div>
            </div>
            
            <div class="row g-4" id="courses-container">
                <!-- Courses will be loaded here -->
            </div>
            
            <div class="text-center mt-4">
                <a href="/onlinecourse/onlinecourse/index.php?controller=Course&action=index" class="btn btn-outline-primary btn-lg">
                    <i class="fas fa-arrow-right"></i> Xem tất cả khóa học
                </a>
            </div>
        </div>
    </section>

    <!-- Categories Section -->
    <section class="py-5" id="categories">
        <div class="container">
            <h2 class="section-title">Danh mục khóa học</h2>
            <p class="section-subtitle">
                Khám phá các danh mục khóa học phù hợp với nhu cầu và mục tiêu của bạn
            </p>
            <div class="row g-4" id="categories-container">
                <!-- Categories will be loaded here -->
            </div>
        </div>
    </section>

    <!-- Instructors Section - Dynamic -->
    <section class="py-5 bg-light" id="instructors">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="display-5 fw-bold mb-3">Đội ngũ giảng viên</h2>
                <p class="lead text-muted">Gặp gỡ đội ngũ giảng viên chuyên môn cao của chúng tôi</p>
            </div>
            
            <div class="row g-4" id="instructors-container">
                <!-- Thầy Giáo Ba -->
                <div class="col-lg-4 col-md-6">
                    <div class="card instructor-card h-100 border-0 shadow-sm">
                        <div class="card-body text-center p-4">
                            <div class="mb-3">
                                <img src="https://picsum.photos/seed/teacher1/150/150.jpg" 
                                     alt="Thầy Giáo Ba" class="rounded-circle" 
                                     style="width: 120px; height: 120px; object-fit: cover;"
                                     onerror="this.onerror=null; this.src='https://randomuser.me/api/portraits/men/32.jpg';">
                            </div>
                            <h5 class="card-title fw-bold mb-2">Thầy Giáo Ba</h5>
                            <p class="text-muted mb-2">Chuyên gia</p>
                            <div class="row g-2 mb-3 text-center">
                                <div class="col-4">
                                    <div class="small text-muted">10 năm</div>
                                    <div class="small fw-bold">kinh nghiệm</div>
                                </div>
                                <div class="col-4">
                                    <div class="small text-muted">15</div>
                                    <div class="small fw-bold">khóa học</div>
                                </div>
                                <div class="col-4">
                                    <div class="small text-muted">4.8</div>
                                    <div class="small">
                                        <i class="fas fa-star text-warning"></i>
                                        <span class="text-warning">Đánh giá</span>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <p class="small text-muted mb-2">
                                    <i class="fas fa-graduation-cap me-1"></i> Thạc sĩ Công nghệ Thông tin - ĐH Bách Khoa
                                </p>
                                <p class="small text-primary mb-0">
                                    <i class="fas fa-envelope me-1"></i> instructor123@course.com
                                </p>
                            </div>
                            <button class="btn btn-primary btn-sm w-100">Liên hệ giảng viên</button>
                        </div>
                    </div>
                </div>
                
                <!-- VuVanQuang -->
                <div class="col-lg-4 col-md-6">
                    <div class="card instructor-card h-100 border-0 shadow-sm">
                        <div class="card-body text-center p-4">
                            <div class="mb-3">
                                <div class="rounded-circle bg-light d-flex align-items-center justify-content-center mx-auto" 
                                     style="width: 120px; height: 120px;">
                                    <i class="fas fa-user-tie fa-3x text-muted"></i>
                                </div>
                            </div>
                            <h5 class="card-title fw-bold mb-2">VuVanQuang</h5>
                            <p class="text-muted mb-2">Chuyên gia</p>
                            <div class="row g-2 mb-3 text-center">
                                <div class="col-4">
                                    <div class="small text-muted">8 năm</div>
                                    <div class="small fw-bold">kinh nghiệm</div>
                                </div>
                                <div class="col-4">
                                    <div class="small text-muted">12</div>
                                    <div class="small fw-bold">khóa học</div>
                                </div>
                                <div class="col-4">
                                    <div class="small text-muted">4.8</div>
                                    <div class="small">
                                        <i class="fas fa-star text-warning"></i>
                                        <span class="text-warning">Đánh giá</span>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <p class="small text-muted mb-2">
                                    <i class="fas fa-graduation-cap me-1"></i> Kỹ sư Phần mềm - ĐH Công nghệ
                                </p>
                                <p class="small text-primary mb-0">
                                    <i class="fas fa-envelope me-1"></i> teacher123@course.com
                                </p>
                            </div>
                            <button class="btn btn-primary btn-sm w-100">Liên hệ giảng viên</button>
                        </div>
                    </div>
                </div>
                
                <!-- Nguyễn Văn Ram Bô -->
                <div class="col-lg-4 col-md-6">
                    <div class="card instructor-card h-100 border-0 shadow-sm">
                        <div class="card-body text-center p-4">
                            <div class="mb-3">
                                <img src="https://picsum.photos/seed/teacher3/150/150.jpg" 
                                     alt="Nguyên Văn Ram Bô" class="rounded-circle" 
                                     style="width: 120px; height: 120px; object-fit: cover;"
                                     onerror="this.onerror=null; this.src='https://randomuser.me/api/portraits/men/32.jpg';">
                            </div>
                            <h5 class="card-title fw-bold mb-2">Nguyên Văn Ram Bô</h5>
                            <p class="text-muted mb-2">Chuyên gia</p>
                            <div class="row g-2 mb-3 text-center">
                                <div class="col-4">
                                    <div class="small text-muted">8 năm</div>
                                    <div class="small fw-bold">kinh nghiệm</div>
                                </div>
                                <div class="col-4">
                                    <div class="small text-muted">18</div>
                                    <div class="small fw-bold">khóa học</div>
                                </div>
                                <div class="col-4">
                                    <div class="small text-muted">4.9</div>
                                    <div class="small">
                                        <i class="fas fa-star text-warning"></i>
                                        <span class="text-warning">Đánh giá</span>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <p class="small text-muted mb-2">
                                    <i class="fas fa-graduation-cap me-1"></i> Chuyên gia Lập trình FPT Aptech
                                </p>
                                <p class="small text-primary mb-0">
                                    <i class="fas fa-envelope me-1"></i> admin@onlinecourse.com
                                </p>
                            </div>
                            <button class="btn btn-primary btn-sm w-100">Liên hệ giảng viên</button>
                        </div>
                    </div>
                </div>
                
                <!-- Đệ Mi Xô -->
                <div class="col-lg-4 col-md-6">
                    <div class="card instructor-card h-100 border-0 shadow-sm">
                        <div class="card-body text-center p-4">
                            <div class="mb-3">
                                <img src="https://picsum.photos/seed/teacher4/150/150.jpg" 
                                     alt="Đệ Mi Xô" class="rounded-circle" 
                                     style="width: 120px; height: 120px; object-fit: cover;"
                                     onerror="this.onerror=null; this.src='https://randomuser.me/api/portraits/men/32.jpg';">
                            </div>
                            <h5 class="card-title fw-bold mb-2">Đệ Mi Xô</h5>
                            <p class="text-muted mb-2">Chuyên gia</p>
                            <div class="row g-2 mb-3 text-center">
                                <div class="col-4">
                                    <div class="small text-muted">7 năm</div>
                                    <div class="small fw-bold">kinh nghiệm</div>
                                </div>
                                <div class="col-4">
                                    <div class="small text-muted">10</div>
                                    <div class="small fw-bold">khóa học</div>
                                </div>
                                <div class="col-4">
                                    <div class="small text-muted">4.7</div>
                                    <div class="small">
                                        <i class="fas fa-star text-warning"></i>
                                        <span class="text-warning">Đánh giá</span>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <p class="small text-muted mb-2">
                                    <i class="fas fa-graduation-cap me-1"></i> Kỹ sư Điện tử - Viễn thông
                                </p>
                                <p class="small text-primary mb-0">
                                    <i class="fas fa-envelope me-1"></i> domixi@onlinecourse.com
                                </p>
                            </div>
                            <button class="btn btn-primary btn-sm w-100">Liên hệ giảng viên</button>
                        </div>
                    </div>
                </div>
                
                <!-- Phạm Quang Linh -->
                <div class="col-lg-4 col-md-6">
                    <div class="card instructor-card h-100 border-0 shadow-sm">
                        <div class="card-body text-center p-4">
                            <div class="mb-3">
                                <img src="https://picsum.photos/seed/teacher5/150/150.jpg" 
                                     alt="Phạm Quang Linh" class="rounded-circle" 
                                     style="width: 120px; height: 120px; object-fit: cover;"
                                     onerror="this.onerror=null; this.src='https://randomuser.me/api/portraits/men/32.jpg';">
                            </div>
                            <h5 class="card-title fw-bold mb-2">Phạm Quang Linh</h5>
                            <p class="text-muted mb-2">Chuyên gia</p>
                            <div class="row g-2 mb-3 text-center">
                                <div class="col-4">
                                    <div class="small text-muted">6 năm</div>
                                    <div class="small fw-bold">kinh nghiệm</div>
                                </div>
                                <div class="col-4">
                                    <div class="small text-muted">8</div>
                                    <div class="small fw-bold">khóa học</div>
                                </div>
                                <div class="col-4">
                                    <div class="small text-muted">4.8</div>
                                    <div class="small">
                                        <i class="fas fa-star text-warning"></i>
                                        <span class="text-warning">Đánh giá</span>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <p class="small text-muted mb-2">
                                    <i class="fas fa-graduation-cap me-1"></i> Thạc sĩ Kinh doanh - Harvard Business School
                                </p>
                                <p class="small text-primary mb-0">
                                    <i class="fas fa-envelope me-1"></i> john.smith@onlinecourse.com
                                </p>
                            </div>
                            <button class="btn btn-primary btn-sm w-100">Liên hệ giảng viên</button>
                        </div>
                    </div>
                </div>
                
                <!-- Đỗ Mễ Xù -->
                <div class="col-lg-4 col-md-6">
                    <div class="card instructor-card h-100 border-0 shadow-sm">
                        <div class="card-body text-center p-4">
                            <div class="mb-3">
                                <div class="rounded-circle bg-light d-flex align-items-center justify-content-center mx-auto" 
                                     style="width: 120px; height: 120px;">
                                    <i class="fas fa-user-tie fa-3x text-muted"></i>
                                </div>
                            </div>
                            <h5 class="card-title fw-bold mb-2">Đỗ Mễ Xù</h5>
                            <p class="text-muted mb-2">Chuyên gia</p>
                            <div class="row g-2 mb-3 text-center">
                                <div class="col-4">
                                    <div class="small text-muted">5 năm</div>
                                    <div class="small fw-bold">kinh nghiệm</div>
                                </div>
                                <div class="col-4">
                                    <div class="small text-muted">6</div>
                                    <div class="small fw-bold">khóa học</div>
                                </div>
                                <div class="col-4">
                                    <div class="small text-muted">4.6</div>
                                    <div class="small">
                                        <i class="fas fa-star text-warning"></i>
                                        <span class="text-warning">Đánh giá</span>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <p class="small text-muted mb-2">
                                    <i class="fas fa-graduation-cap me-1"></i> Cử nhân Công nghệ thông tin
                                </p>
                                <p class="small text-primary mb-0">
                                    <i class="fas fa-envelope me-1"></i> domixu@onlinecourse.com
                                </p>
                            </div>
                            <button class="btn btn-primary btn-sm w-100">Liên hệ giảng viên</button>
                        </div>
                    </div>
                </div>
                
                <!-- Nguyễn Thúc Thủy Tiên -->
                <div class="col-lg-4 col-md-6">
                    <div class="card instructor-card h-100 border-0 shadow-sm">
                        <div class="card-body text-center p-4">
                            <div class="mb-3">
                                <img src="https://picsum.photos/seed/teacher7/150/150.jpg" 
                                     alt="Nguyễn Thúc Thủy Tiên" class="rounded-circle" 
                                     style="width: 120px; height: 120px; object-fit: cover;"
                                     onerror="this.onerror=null; this.src='https://randomuser.me/api/portraits/men/32.jpg';">
                            </div>
                            <h5 class="card-title fw-bold mb-2">Nguyễn Thúc Thủy Tiên</h5>
                            <p class="text-muted mb-2">Chuyên gia</p>
                            <div class="row g-2 mb-3 text-center">
                                <div class="col-4">
                                    <div class="small text-muted">4 năm</div>
                                    <div class="small fw-bold">kinh nghiệm</div>
                                </div>
                                <div class="col-4">
                                    <div class="small text-muted">5</div>
                                    <div class="small fw-bold">khóa học</div>
                                </div>
                                <div class="col-4">
                                    <div class="small text-muted">4.5</div>
                                    <div class="small">
                                        <i class="fas fa-star text-warning"></i>
                                        <span class="text-warning">Đánh giá</span>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <p class="small text-muted mb-2">
                                    <i class="fas fa-graduation-cap me-1"></i> Kỹ sư Phần mềm - ĐH FPT
                                </p>
                                <p class="small text-primary mb-0">
                                    <i class="fas fa-envelope me-1"></i> thuytien@onlinecourse.com
                                </p>
                            </div>
                            <button class="btn btn-primary btn-sm w-100">Liên hệ giảng viên</button>
                        </div>
                    </div>
                </div>
                
                <!-- Nguyễn Văn Tiến -->
                <div class="col-lg-4 col-md-6">
                    <div class="card instructor-card h-100 border-0 shadow-sm">
                        <div class="card-body text-center p-4">
                            <div class="mb-3">
                                <div class="rounded-circle bg-light d-flex align-items-center justify-content-center mx-auto" 
                                     style="width: 120px; height: 120px;">
                                    <i class="fas fa-user-tie fa-3x text-muted"></i>
                                </div>
                            </div>
                            <h5 class="card-title fw-bold mb-2">Nguyễn Văn Tiến</h5>
                            <p class="text-muted mb-2">Chuyên gia</p>
                            <div class="row g-2 mb-3 text-center">
                                <div class="col-4">
                                    <div class="small text-muted">3 năm</div>
                                    <div class="small fw-bold">kinh nghiệm</div>
                                </div>
                                <div class="col-4">
                                    <div class="small text-muted">4</div>
                                    <div class="small fw-bold">khóa học</div>
                                </div>
                                <div class="col-4">
                                    <div class="small text-muted">4.4</div>
                                    <div class="small">
                                        <i class="fas fa-star text-warning"></i>
                                        <span class="text-warning">Đánh giá</span>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <p class="small text-muted mb-2">
                                    <i class="fas fa-graduation-cap me-1"></i> Cử nhân An toàn thông tin
                                </p>
                                <p class="small text-primary mb-0">
                                    <i class="fas fa-envelope me-1"></i> nguyentien@onlinecourse.com
                                </p>
                            </div>
                            <button class="btn btn-primary btn-sm w-100">Liên hệ giảng viên</button>
                        </div>
                    </div>
                </div>
                
                <!-- Lã Thị Anh -->
                <div class="col-lg-4 col-md-6">
                    <div class="card instructor-card h-100 border-0 shadow-sm">
                        <div class="card-body text-center p-4">
                            <div class="mb-3">
                                <img src="https://picsum.photos/seed/teacher9/150/150.jpg" 
                                     alt="Lã Thị Anh" class="rounded-circle" 
                                     style="width: 120px; height: 120px; object-fit: cover;"
                                     onerror="this.onerror=null; this.src='https://randomuser.me/api/portraits/men/32.jpg';">
                            </div>
                            <h5 class="card-title fw-bold mb-2">Lã Thị Anh</h5>
                            <p class="text-muted mb-2">Chuyên gia</p>
                            <div class="row g-2 mb-3 text-center">
                                <div class="col-4">
                                    <div class="small text-muted">2 năm</div>
                                    <div class="small fw-bold">kinh nghiệm</div>
                                </div>
                                <div class="col-4">
                                    <div class="small text-muted">3</div>
                                    <div class="small fw-bold">khóa học</div>
                                </div>
                                <div class="col-4">
                                    <div class="small text-muted">4.3</div>
                                    <div class="small">
                                        <i class="fas fa-star text-warning"></i>
                                        <span class="text-warning">Đánh giá</span>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <p class="small text-muted mb-2">
                                    <i class="fas fa-graduation-cap me-1"></i> Kỹ sư Phần mềm - ĐH Công nghệ
                                </p>
                                <p class="small text-primary mb-0">
                                    <i class="fas fa-envelope me-1"></i> lananh@onlinecourse.com
                                </p>
                            </div>
                            <button class="btn btn-primary btn-sm w-100">Liên hệ giảng viên</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Stats Section -->
    <section class="stats-section">
        <div class="container">
            <div class="row g-4">
                <div class="col-md-3">
                    <div class="stat-card">
                        <div class="stat-number" data-count="5000+">0</div>
                        <div class="stat-label">Học viên</div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stat-card">
                        <div class="stat-number" data-count="150">0</div>
                        <div class="stat-label">Khóa học</div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stat-card">
                        <div class="stat-number" data-count="50">0</div>
                        <div class="stat-label">Giảng viên</div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stat-card">
                        <div class="stat-number" data-count="98">0<small>%</small></div>
                        <div class="stat-label">Hài lòng</div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Testimonials Section -->
    <section class="py-5 bg-light" id="testimonials">
        <div class="container">
            <h2 class="section-title">Học viên nói gì về chúng tôi</h2>
            <p class="section-subtitle">
                Những chia sẻ chân thực từ học viên đã hoàn thành khóa học
            </p>
            <div class="row g-4" id="testimonials-container">
                <!-- Testimonials will be loaded here -->
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="cta-section">
        <div class="container">
            <div class="cta-content">
                <h2 class="cta-title">Sẵn sàng bắt đầu hành trình lập trình?</h2>
                <p class="cta-text">
                    Tham gia ngay hôm nay và nhận ưu đãi đặc biệt dành cho học viên mới
                </p>
                <div class="d-flex gap-3 justify-content-center flex-wrap">
                    <a href="/onlinecourse/onlinecourse/index.php?controller=Auth&action=register" class="btn btn-light btn-lg">
                        <i class="fas fa-rocket"></i> Bắt đầu học miễn phí
                    </a>
                    <a href="#courses" class="btn btn-outline-light btn-lg">
                        <i class="fas fa-book-open"></i> Khám phá khóa học
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer>
        <div class="container">
            <div class="row">
                <div class="col-lg-4 col-md-6 mb-4">
                    <a href="#" class="footer-logo">
                        <i class="fas fa-graduation-cap"></i> OnlineCourse
                    </a>
                    <p class="footer-about">
                        OnlineCourse là nền tảng đào tạo trực tuyến hàng đầu Việt Nam, 
                        cung cấp các khóa học chất lượng cao về lập trình và công nghệ thông tin.
                    </p>
                    <div class="social-links">
                        <a href="https://www.facebook.com/quang.nguyen.490818/" class="social-link" target="_blank"><i class="fab fa-facebook-f"></i></a>
                        <a href="https://www.instagram.com/wang_uen/" class="social-link" target="_blank"><i class="fab fa-instagram"></i></a>
                        <a href="https://www.tiktok.com/@weng_nguyn" class="social-link" target="_blank"><i class="fab fa-tiktok"></i></a>
                    </div>
                </div>
                <div class="col-lg-2 col-md-6 mb-4">
                    <h3 class="footer-title">Về chúng tôi</h3>
                    <ul class="footer-links">
                        <li><a href="/onlinecourse/onlinecourse/index.php?controller=Page&action=about">Giới thiệu</a></li>
                        <li><a href="/onlinecourse/onlinecourse/index.php?controller=Page&action=instructors">Đội ngũ giảng viên</a></li>
                        <li><a href="/onlinecourse/onlinecourse/index.php?controller=Page&action=careers">Tuyển dụng</a></li>
                        <li><a href="/onlinecourse/onlinecourse/index.php?controller=Page&action=terms">Điều khoản dịch vụ</a></li>
                        <li><a href="/onlinecourse/onlinecourse/index.php?controller=Page&action=privacy">Chính sách bảo mật</a></li>
                    </ul>
                </div>
                <div class="col-lg-2 col-md-6 mb-4">
                    <h3 class="footer-title">Danh mục khóa học</h3>
                    <ul class="footer-links">
                        <li><a href="#">Lập trình Web</a></li>
                        <li><a href="#">Lập trình di động</a></li>
                        <li><a href="#">Khoa học dữ liệu</a></li>
                        <li><a href="#">Trí tuệ nhân tạo</a></li>
                        <li><a href="#">Lập trình game</a></li>
                    </ul>
                </div>
                <div class="col-lg-2 col-md-6 mb-4">
                    <h3 class="footer-title">Liên hệ</h3>
                    <div class="footer-contact">
                        <p><i class="fas fa-map-marker-alt"></i>số 1 Thái Hà, Đống Đa, Hà Nội</p>
                        <p><i class="fas fa-phone-alt"></i> 0342381276</p>
                        <p><i class="fas fa-envelope"></i>quangnguyenvan2k5@gmai.com</p>
                        <p><i class="fab fa-facebook"></i> <a href="https://www.facebook.com/quang.nguyen.490818/" target="_blank" style="color: white; text-decoration: none;">Facebook</a></p>
                        <p><i class="fab fa-instagram"></i> <a href="https://www.instagram.com/wang_uen/" target="_blank" style="color: white; text-decoration: none;">Instagram</a></p>
                        <p><i class="fab fa-tiktok"></i> <a href="https://www.tiktok.com/@weng_nguyn" target="_blank" style="color: white; text-decoration: none;">TikTok</a></p>
                        <p><i class="fas fa-clock"></i> Thứ 2 - Thứ 7: 8:00 - 22:00</p>
                    </div>
                </div>
            </div>
            <div class="footer-bottom">
                <p class="mb-0">&copy; Onlinecurse 2025 Mang Lại Trải Nghiệm Chưa Từng Có Cho Tất Cả Người Dùng</p>
            </div>
        </div>
    </footer>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.js"></script>
    <script src="/onlinecourse/onlinecourse/assets/js/script.js"></script>
    <script>
        
        const categories = [
            { name: "Lập trình Web", icon: "fa-laptop-code", count: 45 },
            { name: "Lập trình di động", icon: "fa-mobile-alt", count: 32 },
            { name: "Khoa học dữ liệu", icon: "fa-database", count: 28 },
            { name: "Trí tuệ nhân tạo", icon: "fa-robot", count: 21 },
            { name: "Lập trình game", icon: "fa-gamepad", count: 18 },
            { name: "DevOps", icon: "fa-server", count: 15 },
            { name: "Security", icon: "fa-shield-alt", count: 12 },
            { name: "Blockchain", icon: "fa-link", count: 8 }
        ];


        // Load courses from database - simplified version
        function loadCourses() {
            console.log('Loading courses...');
            
            const container = document.getElementById('courses-container');
            
            // Direct course data from database
            const courses = [
                {
                    id: 20,
                    title: "HTML cơ bản",
                    category: "Data Science", 
                    instructor: "Thầy Giáo Ba",
                    rating: 4.8,
                    ratingCount: 1713,
                    price: "200000.00",
                    originalPrice: 300000,
                    badge: "Phổ biến",
                    image: "https://aptechvietnam.com.vn/wp-content/uploads/HTML-Blog-Cover.png"
                },
                {
                    id: 6,
                    title: "JavaScript Masterclass",
                    category: "Lập trình Web",
                    instructor: "Nguyên Văn Ram Bô",
                    rating: 5.3,
                    ratingCount: 1442,
                    price: "799000.00",
                    originalPrice: 1198500,
                    badge: "Phổ biến",
                    image: "https://fstacademy.com/wp-content/uploads/2022/07/Free-Courses-to-learn-JavaScript.jpg"
                },
                {
                    id: 7,
                    title: "UI/UX Design Fundamentals",
                    category: "Lập trình Mobile",
                    instructor: "Đệ Mi Xô",
                    rating: 4.8,
                    ratingCount: 1125,
                    price: "599000.00",
                    originalPrice: 898500,
                    badge: "Phổ biến",
                    image: "https://www.mindinventory.com/blog/wp-content/uploads/2023/11/difference-between-ui-ux.webp"
                },
                {
                    id: 8,
                    title: "Adobe Photoshop Pro",
                    category: "Lập trình Mobile",
                    instructor: "Đệ Mi Xô",
                    rating: 5.1,
                    ratingCount: 1276,
                    price: "499000.00",
                    originalPrice: 748500,
                    badge: "Phổ biến",
                    image: "https://st.download.com.vn/data/image/2025/04/18/Adobe-Photoshop-CC-2025.jpg"
                },
                {
                    id: 9,
                    title: "Digital Marketing Strategy",
                    category: "Data Science",
                    instructor: "Phạm Quang Linh",
                    rating: 4.8,
                    ratingCount: 1553,
                    price: "699000.00",
                    originalPrice: 1048500,
                    badge: "Phổ biến",
                    image: "https://static.geekschip.com/data/category_images/1647524654_0.jpg"
                },
                {
                    id: 10,
                    title: "Startup Funding 101",
                    category: "Data Science",
                    instructor: "Phạm Quang Linh",
                    rating: 5.2,
                    ratingCount: 1889,
                    price: "899000.00",
                    originalPrice: 1348500,
                    badge: "Phổ biến",
                    image: "https://technoidentity.com/wp-content/uploads/2021/04/blog-Startup-Funding-101.jpg"
                }
            ];
            
            console.log('Courses data ready:', courses.length);
            
            container.innerHTML = courses.map(course => `
                <div class="col-md-6 col-lg-4">
                    <a href="/onlinecourse/onlinecourse/index.php?controller=Course&action=detail&id=${course.id}" class="text-decoration-none">
                        <div class="course-card">
                            <div class="position-relative">
                                <img src="${course.image}" alt="${course.title}" class="course-img">
                                <span class="course-badge">${course.badge}</span>
                            </div>
                            <div class="course-body">
                                <div class="course-category">${course.category}</div>
                                <h3 class="course-title">${course.title}</h3>
                                <p class="course-instructor">Bởi ${course.instructor}</p>
                                <div class="course-meta">
                                    <div class="course-rating">
                                        <span class="stars">
                                            ${generateStars(course.rating)}
                                        </span>
                                        <span class="rating-count">${course.rating}</span>
                                        <span class="rating-count">(${course.ratingCount})</span>
                                    </div>
                                    <div class="course-price">
                                        ${course.originalPrice ? `<span class="original-price">${formatCurrency(course.originalPrice)}</span>` : ''}
                                        ${formatCurrency(course.price)}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            `).join('');
            
            console.log('Courses rendered successfully');
        }

        // Fallback function - load courses directly from database
        async function loadSampleCourses() {
            console.log('Fallback: Attempting to load courses...');
            try {
                console.log('Fallback: Fetching load_courses.php...');
                const response = await fetch('load_courses.php');
                console.log('Fallback: Response status:', response.status);
                console.log('Fallback: Response ok:', response.ok);
                
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                
                const courses = await response.json();
                console.log('Fallback: Courses loaded:', courses);
                console.log('Fallback: Number of courses:', courses.length);
                
                const container = document.getElementById('courses-container');
                container.innerHTML = courses.map(course => `
                    <div class="col-md-6 col-lg-4">
                        <a href="/onlinecourse/onlinecourse/index.php?controller=Course&action=detail&id=${course.id}" class="text-decoration-none">
                            <div class="course-card">
                                <div class="position-relative">
                                    <img src="${course.image}" alt="${course.title}" class="course-img">
                                    <span class="course-badge">${course.badge}</span>
                                </div>
                                <div class="course-body">
                                    <div class="course-category">${course.category}</div>
                                    <h3 class="course-title">${course.title}</h3>
                                    <p class="course-instructor">Bởi ${course.instructor}</p>
                                    <div class="course-meta">
                                        <div class="course-rating">
                                            <span class="stars">
                                                ${generateStars(course.rating)}
                                            </span>
                                            <span class="rating-count">${course.rating}</span>
                                            <span class="rating-count">(${course.ratingCount})</span>
                                        </div>
                                        <div class="course-price">
                                            ${course.originalPrice ? `<span class="original-price">${formatCurrency(course.originalPrice)}</span>` : ''}
                                            ${formatCurrency(course.price)}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                `).join('');
            } catch (error) {
                console.error('Error in fallback:', error);
                // Show error message
                const container = document.getElementById('courses-container');
                container.innerHTML = '<div class="col-12 text-center"><p class="text-danger">Không thể tải khóa học. Vui lòng thử lại sau.</p></div>';
            }
        }

        // Load real statistics from database
        function loadStats() {
            return fetch('load_stats.php')
                .then(response => {
                    if (!response.ok) {
                        throw new Error(`HTTP error! status: ${response.status}`);
                    }
                    return response.json();
                })
                .then(stats => {
                    console.log('Stats loaded:', stats);
                    
                    // Validate stats data
                    const validStats = {
                        students: parseInt(stats.students) || 0,
                        courses: parseInt(stats.courses) || 0,
                        instructors: parseInt(stats.instructors) || 0,
                        satisfaction: parseInt(stats.satisfaction) || 95
                    };
                    
                    // Update stat numbers with real data
                    const statElements = document.querySelectorAll('.stat-number');
                    
                    // Students
                    if (statElements[0]) {
                        statElements[0].setAttribute('data-count', '5000+');
                        statElements[0].textContent = '5000+';
                    }
                    
                    // Courses
                    if (statElements[1]) {
                        statElements[1].setAttribute('data-count', validStats.courses);
                        statElements[1].textContent = '0'; // Reset to 0 for animation
                    }
                    
                    // Instructors
                    if (statElements[2]) {
                        statElements[2].setAttribute('data-count', validStats.instructors);
                        statElements[2].textContent = '0'; // Reset to 0 for animation
                    }
                    
                   if (statElements[3]) {
                        statElements[3].innerHTML = '0<small>%</small>'; // Reset to 0 for animation
                        statElements[3].setAttribute('data-count', validStats.satisfaction);
                    }
                    return validStats;
                })
                .catch(error => {
                    console.error('Error loading stats:', error);
                    
                    // Fallback to default values
                    const defaultStats = {
                        students: '5000+',
                        courses: 150,
                        instructors: 4000,
                        satisfaction: 5000
                    };
                    
                    // Update with fallback values
                    const statElements = document.querySelectorAll('.stat-number');
                    
                    if (statElements[0]) {
                        statElements[0].setAttribute('data-count', '5000+');
                        statElements[0].textContent = '5000+';
                    }
                    if (statElements[1]) {
                        statElements[1].setAttribute('data-count', defaultStats.courses);
                        statElements[1].textContent = '0';
                    }
                    if (statElements[2]) {
                        statElements[2].setAttribute('data-count', defaultStats.instructors);
                        statElements[2].textContent = '0';
                    }
                    if (statElements[3]) {
                        statElements[3].innerHTML = '0<small></small>';
                        statElements[3].setAttribute('data-count', defaultStats.satisfaction);
                    }
                    
                    return defaultStats;
                });
        }
        // Load categories from database - simplified version
        function loadCategories() {
            console.log('Loading categories...');
            
            const container = document.getElementById('categories-container');
            
            // Direct category data from database
            const categories = [
                { name: "UI/UX Design", icon: "fa-paint-brush", count: 4 },
                { name: "Data Science", icon: "fa-chart-bar", count: 3 },
                { name: "Lập trình Mobile", icon: "fa-mobile-alt", count: 3 },
                { name: "Lập trình Web", icon: "fa-code", count: 2 },
                { name: "Database", icon: "fa-database", count: 1 },
                { name: "Lập trình", icon: "fa-laptop-code", count: 1 },
                { name: "Thiết kế", icon: "fa-palette", count: 1 }
            ];
            
            console.log('Categories data ready:', categories.length);
            
            container.innerHTML = categories.map(category => `
                <div class="col-md-6 col-lg-3">
                    <div class="category-card">
                        <div class="category-icon">
                            <i class="fas ${category.icon}"></i>
                        </div>
                        <h3 class="category-title">${category.name}</h3>
                        <p class="category-count">${category.count} khóa học</p>
                    </div>
                </div>
            `).join('');
            
            console.log('Categories rendered successfully');
        }

        
        // Load instructors from database - Dynamic version
        function loadInstructors() {
            console.log('Loading instructors from database...');
            
            const container = document.getElementById('instructors-container');
            console.log('Container found:', !!container);
            
            if (!container) {
                console.error('Instructors container not found!');
                return;
            }
            
            // Load instructors from database API directly
            const instructors = [];
            
            const colors = ['primary', 'success', 'warning', 'danger', 'info', 'secondary', 'dark'];
            
            try {
                container.innerHTML = instructors.map((instructor, index) => {
                    const color = colors[index % colors.length];
                    
                    const avatarHtml = instructor.avatar && instructor.avatar !== null && instructor.avatar.trim() !== '' ? 
                        `<img src="${instructor.avatar}" alt="${instructor.name}" 
                         class="rounded-circle" style="width: 120px; height: 120px; object-fit: cover;"
                         onerror="this.onerror=null; this.src='https://picsum.photos/seed/${instructor.name.replace(/\s+/g, '')}/120/120.jpg';">` : 
                        `<div class="rounded-circle bg-light d-flex align-items-center justify-content-center mb-3 mx-auto" 
                             style="width: 120px; height: 120px;">
                            <i class="fas fa-user-tie fa-3x text-muted"></i>
                        </div>`;
                    
                    return `
                        <div class="col-md-4 mb-4">
                            <div class="card h-100 shadow-sm">
                                <div class="card-body text-center">
                                    <div class="mb-3">
                                        ${avatarHtml}
                                    </div>
                                    <h5 class="card-title fw-bold">${instructor.name}</h5>
                                    <p class="text-muted">${instructor.specialization}</p>
                                    <p class="small">${instructor.bio}</p>
                                    
                                    <div class="row text-center small mb-3">
                                        <div class="col-4">
                                            <div class="fw-bold text-primary">${instructor.experience}</div>
                                            <div class="text-muted">Kinh nghiệm</div>
                                        </div>
                                        <div class="col-4">
                                            <div class="fw-bold text-success">${instructor.courses}</div>
                                            <div class="text-muted">Khóa học</div>
                                        </div>
                                        <div class="col-4">
                                            <div class="fw-bold text-warning">${instructor.rating}</div>
                                            <div class="text-muted">Đánh giá</div>
                                        </div>
                                    </div>
                                    
                                    <p class="small text-muted mb-2">
                                        <i class="fas fa-graduation-cap me-1"></i> ${instructor.education}
                                    </p>
                                    
                                    <p class="text-${color} small mb-3">
                                        <i class="fas fa-envelope me-1"></i> ${instructor.email}
                                    </p>
                                    
                                    <button class="btn btn-outline-primary btn-sm w-100" onclick="openContactModal(${JSON.stringify(instructor).replace(/"/g, '&quot;')})">
                                        <i class="fas fa-envelope me-1"></i> Liên hệ giảng viên
                                    </button>
                                </div>
                            </div>
                        </div>
                    `;
                }).join('');
                
                console.log('Instructors rendered successfully:', instructors.length);
                
                // Also try fetch API for future updates
                console.log('Starting API fetch for instructors...');
                fetch('load_instructors.php')
                    .then(response => {
                        console.log('API response status:', response.status);
                        return response.json();
                    })
                    .then(data => {
                        console.log('API data received:', data);
                        if (data.success && data.instructors) {
                            // Update with real data if API works
                            const apiInstructors = data.instructors;
                            console.log('Processing API instructors:', apiInstructors.length);
                            
                            container.innerHTML = apiInstructors.map((instructor, index) => {
                                const color = colors[index % colors.length];
                                
                                console.log(`Instructor ${index}: ${instructor.name}, avatar:`, instructor.avatar);
                                
                                const avatarHtml = instructor.avatar && instructor.avatar !== null && instructor.avatar.trim() !== '' ? 
                                    `<img src="${instructor.avatar}" alt="${instructor.name}" 
                                     class="rounded-circle" style="width: 120px; height: 120px; object-fit: cover;" 
                                     onerror="this.onerror=null; this.src='https://picsum.photos/seed/${instructor.name.replace(/\s+/g, '')}/120/120.jpg';">` : 
                                    `<div class="rounded-circle bg-light d-flex align-items-center justify-content-center mb-3 mx-auto" 
                                         style="width: 120px; height: 120px;">
                                        <i class="fas fa-user-tie fa-3x text-muted"></i>
                                    </div>`;
                                
                                return `
                                    <div class="col-md-4 mb-4">
                                        <div class="card h-100 shadow-sm">
                                            <div class="card-body text-center">
                                                <div class="mb-3">
                                                    ${avatarHtml}
                                                </div>
                                                <h5 class="card-title fw-bold">${instructor.name}</h5>
                                                <p class="text-muted">${instructor.specialization}</p>
                                                <p class="small">${instructor.bio}</p>
                                                
                                                <div class="row text-center small mb-3">
                                                    <div class="col-4">
                                                        <div class="fw-bold text-primary">${instructor.experience || 'N/A'}</div>
                                                        <div class="text-muted">Kinh nghiệm</div>
                                                    </div>
                                                    <div class="col-4">
                                                        <div class="fw-bold text-success">${instructor.courses || 'N/A'}</div>
                                                        <div class="text-muted">Khóa học</div>
                                                    </div>
                                                    <div class="col-4">
                                                        <div class="fw-bold text-warning">${instructor.rating || 'N/A'}</div>
                                                        <div class="text-muted">Đánh giá</div>
                                                    </div>
                                                </div>
                                                
                                                <p class="small text-muted mb-2">
                                                    <i class="fas fa-graduation-cap me-1"></i> ${instructor.education || 'Chưa cập nhật'}
                                                </p>
                                                
                                                <p class="text-${color} small mb-3">
                                                    <i class="fas fa-envelope me-1"></i> ${instructor.email}
                                                </p>
                                                
                                                <button class="btn btn-outline-primary btn-sm w-100" onclick="openContactModal(${JSON.stringify(instructor).replace(/"/g, '&quot;')})">
                                                    <i class="fas fa-envelope me-1"></i> Liên hệ giảng viên
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                `;
                            }).join('');
                            console.log('Updated with API data:', apiInstructors.length);
                        } else {
                            console.error('API returned no instructors:', data);
                        }
                    })
                    .catch(error => {
                        console.error('API failed, using fallback data:', error);
                    });
                    
            } catch (error) {
                console.error('Error rendering instructors:', error);
                container.innerHTML = `
                    <div class="col-12 text-center">
                        <p class="text-muted">Lỗi hiển thị giảng viên.</p>
                    </div>
                `;
            }
        }

        // Load testimonials from database
        function loadTestimonials() {
            fetch('load_testimonials.php')
                .then(response => response.json())
                .then(data => {
                    console.log('API response:', data);
                    const container = document.getElementById('testimonials-container');
                    
                    if (data.success && data.testimonials && data.testimonials.length > 0) {
                        console.log('Testimonials loaded from database:', data.testimonials.length);
                        container.innerHTML = data.testimonials.map(testimonial => `
                            <div class="col-md-6 col-lg-4">
                                <div class="testimonial-card">
                                    <p class="testimonial-text">${testimonial.text}</p>
                                    <div class="testimonial-author">
                                        <div class="testimonial-info">
                                            <h5>${testimonial.name}</h5>
                                            <p>${testimonial.role}</p>
                                        </div>
                                    </div>
                                    <div class="testimonial-rating">
                                        ${generateStars(testimonial.rating)}
                                    </div>
                                </div>
                            </div>
                        `).join('');
                    } else {
                        console.log('No testimonials found in database');
                        container.innerHTML = '<div class="col-12 text-center"><p class="text-muted">Chưa có đánh giá nào từ học viên.</p></div>';
                    }
                })
                .catch(error => {
                    console.error('Error loading testimonials:', error);
                    const container = document.getElementById('testimonials-container');
                    container.innerHTML = '<div class="col-12 text-center"><p class="text-muted">Không thể tải đánh giá. Vui lòng thử lại sau.</p></div>';
                });
        }

        // Helper functions
        function generateStars(rating) {
            const fullStars = Math.floor(rating);
            const halfStar = rating % 1 >= 0.5 ? 1 : 0;
            const emptyStars = 5 - fullStars - halfStar;
            
            let stars = '';
            for (let i = 0; i < fullStars; i++) {
                stars += '<i class="fas fa-star"></i>';
            }
            if (halfStar) {
                stars += '<i class="fas fa-star-half-alt"></i>';
            }
            for (let i = 0; i < emptyStars; i++) {
                stars += '<i class="far fa-star"></i>';
            }
            return stars;
        }

        function formatCurrency(amount) {
            return new Intl.NumberFormat('vi-VN', {
                style: 'currency',
                currency: 'VND',
                minimumFractionDigits: 0
            }).format(amount);
        }

        // Animated counter for stats
        function animateCounter(element, target, duration = 2000) {
            // Validate target to prevent NaN
            target = parseInt(target) || 0;
            if (target === 0) {
                // If target is 0, just display 0 immediately
                if (element.innerHTML.includes('%') || element.getAttribute('data-count') === element.getAttribute('data-count')) {
                    element.innerHTML = '0<small>%</small>';
                } else {
                    element.textContent = '0';
                }
                return;
            }
            
            const start = 0;
            const increment = target / (duration / 16);
            let current = start;
            
            const timer = setInterval(() => {
                current += increment;
                if (current >= target) {
                    current = target;
                    clearInterval(timer);
                }
                
                // Check if this is the satisfaction percentage element
                const isPercentageElement = element.getAttribute('data-count') && element.innerHTML.includes('%');
                
                if (isPercentageElement) {
                    element.innerHTML = Math.floor(current) + '<small>%</small>';
                } else {
                    element.textContent = Math.floor(current).toLocaleString();
                }
            }, 16);
        }

        // Fade in animation
        function handleScroll() {
            const elements = document.querySelectorAll('.fade-in');
            elements.forEach(element => {
                const rect = element.getBoundingClientRect();
                const isVisible = rect.top < window.innerHeight && rect.bottom > 0;
                if (isVisible) {
                    element.classList.add('visible');
                }
            });
        }

        // Initialize everything when DOM is loaded
        document.addEventListener('DOMContentLoaded', function() {
            // Load content
            loadCourses();
            loadCategories();
            loadInstructors();
            loadTestimonials();
            
            // Load stats first, then setup animations
            loadStats().then(() => {
                console.log('Stats loaded, setting up animations...');
                
                // Initialize animations after stats are loaded
                handleScroll();
                window.addEventListener('scroll', handleScroll);
                
                // Animate stats when visible
                const observer = new IntersectionObserver((entries) => {
                    entries.forEach(entry => {
                        if (entry.isIntersecting) {
                            const statNumber = entry.target;
                            const target = parseInt(statNumber.getAttribute('data-count'));
                            console.log('Animating stat to:', target);
                            animateCounter(statNumber, target);
                            observer.unobserve(statNumber);
                        }
                    });
                });
                
                document.querySelectorAll('.stat-number').forEach(stat => {
                    observer.observe(stat);
                });
            }).catch(error => {
                console.error('Error in stats loading:', error);
            });
            
            // Smooth scrolling for anchor links
            document.querySelectorAll('a[href^="#"]').forEach(anchor => {
                anchor.addEventListener('click', function (e) {
                    e.preventDefault();
                    const targetId = this.getAttribute('href');
                    if (targetId === '#') return;
                    
                    const targetElement = document.querySelector(targetId);
                    if (targetElement) {
                        targetElement.scrollIntoView({
                            behavior: 'smooth',
                            block: 'start'
                        });
                    }
                });
            });
            
            // Add hover effects to course cards
            document.querySelectorAll('.course-card').forEach(card => {
                card.addEventListener('mouseenter', function() {
                    this.style.transform = 'translateY(-5px)';
                });
                
                card.addEventListener('mouseleave', function() {
                    this.style.transform = 'translateY(0)';
                });
            });
        });
    </script>

    <!-- Modal Liên hệ Giảng viên -->
    <div class="modal fade" id="contactInstructorModal" tabindex="-1" aria-labelledby="contactInstructorModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="contactInstructorModalLabel">
                        <i class="fas fa-envelope me-2"></i>
                        Liên hệ Giảng viên
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row mb-3">
                        <div class="col-md-3 text-center">
                            <img id="modalInstructorAvatar" src="https://picsum.photos/seed/instructor/150/150.jpg" 
                                 class="rounded-circle mb-2" style="width: 100px; height: 100px; object-fit: cover;">
                            <h6 id="modalInstructorName" class="mb-1">Tên giảng viên</h6>
                            <small id="modalInstructorSpecialization" class="text-muted">Chuyên môn</small>
                        </div>
                        <div class="col-md-9">
                            <form id="contactInstructorForm">
                                <input type="hidden" id="instructorId" name="instructor_id">
                                <input type="hidden" id="instructorEmail" name="instructor_email">
                                
                                <div class="mb-3">
                                    <label for="studentName" class="form-label">Họ và tên của bạn *</label>
                                    <input type="text" class="form-control" id="studentName" name="student_name" required>
                                </div>
                                
                                <div class="mb-3">
                                    <label for="studentEmail" class="form-label">Email của bạn *</label>
                                    <input type="email" class="form-control" id="studentEmail" name="student_email" required>
                                </div>
                                
                                <div class="mb-3">
                                    <label for="studentPhone" class="form-label">Số điện thoại</label>
                                    <input type="tel" class="form-control" id="studentPhone" name="student_phone">
                                </div>
                                
                                <div class="mb-3">
                                    <label for="subject" class="form-label">Chủ đề *</label>
                                    <select class="form-select" id="subject" name="subject" required>
                                        <option value="">Chọn chủ đề</option>
                                        <option value="hoc_them">Hỏi thêm về khóa học</option>
                                        <option value="tuvan">Tư vấn lộ trình học tập</option>
                                        <option value="dangky">Đăng ký khóa học</option>
                                        <option value="khac">Chủ đề khác</option>
                                    </select>
                                </div>
                                
                                <div class="mb-3">
                                    <label for="message" class="form-label">Nội dung tin nhắn *</label>
                                    <textarea class="form-control" id="message" name="message" rows="4" required 
                                              placeholder="Nhập nội dung bạn muốn gửi cho giảng viên..."></textarea>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times me-1"></i> Hủy
                    </button>
                    <button type="button" class="btn btn-primary" onclick="sendContactMessage()">
                        <i class="fas fa-paper-plane me-1"></i> Gửi tin nhắn
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Hàm mở modal liên hệ giảng viên
        function openContactModal(instructor) {
            document.getElementById('instructorId').value = instructor.id;
            document.getElementById('instructorEmail').value = instructor.email;
            document.getElementById('modalInstructorName').textContent = instructor.name;
            document.getElementById('modalInstructorSpecialization').textContent = instructor.specialization;
            
            // Cập nhật avatar
            const avatarElement = document.getElementById('modalInstructorAvatar');
            if (instructor.avatar && instructor.avatar.trim() !== '') {
                avatarElement.src = instructor.avatar;
            } else {
                avatarElement.src = `https://picsum.photos/seed/${instructor.name}/150/150.jpg`;
            }
            
            // Reset form
            document.getElementById('contactInstructorForm').reset();
            
            // Hiển thị modal
            const modal = new bootstrap.Modal(document.getElementById('contactInstructorModal'));
            modal.show();
        }
        
        // Hàm gửi tin nhắn liên hệ
        function sendContactMessage() {
            const form = document.getElementById('contactInstructorForm');
            
            // Validate form
            if (!form.checkValidity()) {
                form.reportValidity();
                return;
            }
            
            const formData = new FormData(form);
            formData.append('action', 'send_contact');
            
            // Hiển thị loading
            const submitBtn = event.target;
            const originalText = submitBtn.innerHTML;
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i> Đang gửi...';
            submitBtn.disabled = true;
            
            fetch('contact_instructor.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Hiển thị thông báo thành công
                    showAlert('success', 'Tin nhắn của bạn đã được gửi thành công! Giảng viên sẽ liên hệ lại sớm.');
                    
                    // Đóng modal
                    const modal = bootstrap.Modal.getInstance(document.getElementById('contactInstructorModal'));
                    modal.hide();
                } else {
                    showAlert('danger', data.message || 'Có lỗi xảy ra. Vui lòng thử lại.');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showAlert('danger', 'Có lỗi xảy ra. Vui lòng thử lại.');
            })
            .finally(() => {
                // Reset button
                submitBtn.innerHTML = originalText;
                submitBtn.disabled = false;
            });
        }
        
        // Hàm hiển thị alert
        function showAlert(type, message) {
            // Xóa alert cũ nếu có
            const oldAlert = document.querySelector('.alert-message');
            if (oldAlert) {
                oldAlert.remove();
            }
            
            // Tạo alert mới
            const alertHtml = `
                <div class="alert alert-${type} alert-dismissible fade show alert-message position-fixed top-0 start-50 translate-middle-x mt-3" 
                     style="z-index: 9999; min-width: 300px;" role="alert">
                    <i class="fas fa-${type === 'success' ? 'check-circle' : 'exclamation-triangle'} me-2"></i>
                    ${message}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            `;
            
            document.body.insertAdjacentHTML('afterbegin', alertHtml);
            
            // Tự động ẩn sau 5 giây
            setTimeout(() => {
                const alert = document.querySelector('.alert-message');
                if (alert) {
                    alert.remove();
                }
            }, 5000);
        }
    </script>

</body>
</html>
