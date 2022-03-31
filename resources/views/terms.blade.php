@extends('layouts.app')

@section('content')
<div class="c-policy">
    <h1>{{ ucwords(str_replace("-", ' ', request()->segment(1))) }} ("Terms")</h1>
    <small>Last updated: August 09, 2018</small>
    <br><br>
    <p>
        Please read these Terms and Conditions ("Terms", "Terms and Conditions") carefully before using the https://www.purplebug.net/ website (the "Service") operated by PurpleBug, Inc. ("us", "we", or "our").
        <br><br>
        Your access to and use of the Service is conditioned on your acceptance of and compliance with these Terms. These Terms apply to all visitors, users and others who access or use the Service.
        <br><br>
        By accessing or using the Service you agree to be bound by these Terms. If you disagree with any part of the terms then you may not access the Service.
        <br><br>

        <strong>I. Intellectual Property Rights</strong>
        <br><br>
        Other than the content you own, under these Terms, PurpleBug, Inc. and/or its licensors own all the intellectual property rights and materials contained in this Website. You are granted limited license only for purposes of viewing the material contained on this Website.
        <br><br>
        <strong>II. Restrictions</strong>
        <br><br>
        You are specifically restricted from all of the following:
        <ol type="a">
            <li>publishing any material contained in this Website in any other media;</li>
            <li>using this Website in any way that is or may be damaging to this Website;</li>
            <li>using this Website in any way that impacts user access to this Form and the Website itself;</li>
            <li>using this Website contrary to applicable laws and regulations, or in any way may cause harm to the Form and to the Website, or to any person or business entity;</li>
            <li>engaging in any data mining, data harvesting, data extracting or any other similar activity in relation to this Website;</li>
            <li>using this Website to engage in any advertising or marketing.</li>
        </ol>
        Certain areas of this Website are restricted from being accessed by you and PurpleBug, Inc. may further restrict access by you to any areas of this Website, at any time, in absolute discretion. Any personal identifiable information you may have for this Website are confidential and you must maintain confidentiality as well.
        <br><br>
        <strong>III. Governing Law</strong>
        <br><br>
        These Terms shall be governed and construed in accordance with the laws of Philippines, without regard to its conflict of law provisions. Our failure to enforce any right or provision of these Terms will not be considered a waiver of those rights. If any provision of these Terms is held to be invalid or unenforceable by a court, the remaining provisions of these Terms will remain in effect. These Terms constitute the entire agreement between us regarding our Service, and supersede and replace any prior agreements we might have between us regarding the Service.
        <br><br>
        <strong>IV. No warranties</strong>
        <br><br>
        In no event shall PurleBug, Inc., nor any of its officers, directors and employees, shall be held liable for anything arising out of or in any way connected with your use of this Website whether such liability is under contract. PurpleBug, Inc., including its officers, directors and employees shall not be held liable for any indirect, consequential or special liability arising out of or in any way related to your use of this Website.
        <br><br>
        <strong>V. Limitation of liability</strong>
        <br><br>
        In no event shall PurleBug, Inc., nor any of its officers, directors and employees, shall be held liable for anything arising out of or in any way connected with your use of this Website whether such liability is under contract. PurpleBug, Inc., including its officers, directors and employees shall not be held liable for any indirect, consequential or special liability arising out of or in any way related to your use of this Website.
        <br><br>
        <strong>VI. Indemnification</strong>
        <br><br>
        You hereby indemnify to the fullest extent PurpleBug, Inc. from and against any and/or all liabilities, costs, demands, causes of action, damages and expenses arising in any way related to your breach of any of the provisions of these Terms.
        <br><br>
        <strong>VII. Severability</strong>
        <br><br>
        If any provision of these Terms is found to be invalid under any applicable law, such provisions shall be deleted without affecting the remaining provisions herein.
        <br><br>
        If any provision of these Terms is found to be invalid under any applicable law, such provisions shall be deleted without affecting the remaining provisions herein.
        <br><br>
        <strong>VIII. Termination</strong>
        <br><br>
        We may terminate or suspend access to our Service immediately, without prior notice or liability, for any reason whatsoever, including without limitation if you breach the Terms. All provisions of the Terms which by their nature should survive termination shall survive termination, including, without limitation, ownership provisions, warranty disclaimers, indemnity and limitations of liability.
        <br><br>
        <strong>IX. Changes</strong>
        <br><br>
        We reserve the right, at our sole discretion, to modify or replace these Terms at any time. If a revision is material we will try to provide at least 30 days’ notice prior to any new terms taking effect. What constitutes a material change will be determined at our sole discretion. By continuing to access or use our Service after those revisions become effective, you agree to be bound by the revised terms. If you do not agree to the new terms, please stop using the Service.
        <br><br>
        <strong>X. Assignment</strong>
        <br><br>
        PurpleBug, Inc. is allowed to assign, transfer, and subcontract its rights and/or obligations under these Terms without any notification. However, you are not allowed to assign, transfer, or subcontract any of your rights and/or obligations under these Terms.
        <br><br>
        <strong>XI. Entire Agreement</strong>
        <br><br>
        These Terms constitute the entire agreement between PurpleBug, Inc. and you in relation to your use of this Website, and supersede all prior agreements and understandings.
        <br><br>
        <strong>XII. Contact Us</strong>
        <br><br>
        If you have any questions about these Terms, please email us at <a href="mailto:inquiries@purplebugmail.net">inquiries@purplebugmail.net</a>.
    </p>
</div>
@endsection

@push('seo')
    <!-- generic meta tags -->
    <title>Terms and Conditions | PurpleBug</title>
    <meta name="description" content="Terms and Conditions | PurpleBug">
    <meta name="keywords" content="Terms and Conditions,PurpleBug">
@endpush