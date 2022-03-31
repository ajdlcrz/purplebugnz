@extends('layouts.app')

@section('content')
<div class="c-policy">
    <h1>{{ ucwords(str_replace("-", ' ', request()->segment(1))) }}</h1>
    <small>Last updated: August 09, 2018</small>
    <br><br>
    <p>
        PurpleBug, Inc. is committed to protect and respect your personal data privacy. This privacy policy is hereby adopted in compliance with Republic Act No. 10173 or the Data Privacy Act of 2012 (DPA), its Implementing Rules and Regulations, and other relevant policies, including issuances of the National Privacy Commission.
        <br><br>
        <strong>I. Information we collect</strong>
        <br><br>
        We collect the following information: name, company name, website URL, contact number, and email address, when users submit through our service inquiry form (“Form”). Meanwhile, for our influencer form, we collect the following information: email address, full name, location, contact number, and other personal information. Automatic Collections: For each HTTP (which is what your Web browser generates when you request a page or part of a page from a Website) request received, we collect and store only the following information:
        <ul>
            <li>the date and time;</li>
            <li>the originating IP address;</li>
            <li>the type of browser and operating system used (if provided by the browser);</li>
            <li>the URL of the referring page (if provided by the browser);</li>
            <li>the object requested completion status of the request pages visited.</li>
        </ul>
        <strong>II. How we use your information</strong>
        <br><br>
        We use the information we collected for the purpose of communicating with our users, such as enabling users to receive email notifications regarding deals they have subscribed to receive alerts about.
        <br><br>
        Users who inquired through the Form will also receive email notifications including additional announcements about our products, services and newsletters. We respect the privacy of all of our users and offer an opt-out service in all of these communications.
        <br><br>
        Subject always to applicable law, we may share your information (particularly, names and contact information such as email addresses and phone numbers) with companies that form part of the same group of companies as we do (the “Group Companies”). Such sharing of data shall solely be for the purpose of allowing the Group Companies to offer their services/products to you if, in our opinion, you may be interested in such services and products. In addition, when you register or send an inquiry, we ask you whether you like to receive offers and services from other third party companies via email and/or via post. You have the ability to opt-out receiving such third party offers during this process.
        <br><br>
        We may also disclose any of your information to any competent governmental authority if asked to disclose such data, without having to notify you.
        <br><br>
        We DO NOT (i) use personal information for any other purpose than to provide information about our products and services, (ii) sell your personal information, (iii) share your personal information with other entities, except as provided in this Policy.
        <br><br>
        <strong>III. Analytics and Tracking Technologies</strong>
        <br><br>
        The Website uses Google Analytics to monitor the effectivity of the Website and improve the Website, based on collected data. The use of Google Analytics is governed by the Google Analytics Terms and Conditions and any other policy that may be force from time to time at Google’s discretion.
        <br><br>
        <strong>IV. Protection Measures</strong>
        <br><br>
        Only authorized PurpleBug, Inc. personnel and personnel of partner organizations, who are compliant with the Data Privacy Act of 2012 shall have access to your data. Your information shall be stored securely in an encrypted database for five (5) years.
        <br><br>
        <strong>V. Access and Correction</strong>
        <br><br>
        You are entitled to certain rights in relation to the Personal Data collected from you, including the right to access and correct your Personal Data being processed, object to the processing, and to lodge a complaint before the National Privacy Commission in case of violation of your rights as data subject.
        <br><br>
        You may send us an e-mail at <a href="mailto:inquiries@purplebugmail.net">inquiries@purplebugmail.net</a> to request access to, correct and/or delete any Personal Data that you have provided to us. Please be advised, however, that We cannot delete your Personal Data without restricting or removing our ability to effectively address your Inquiry. We may not accommodate a request to correct and/or delete Personal Data if We believe the same would violate any law or legal requirement or cause the Personal Data to be incorrect.
        <br><br>
        This Privacy Policy is effective as of Dec 23, 2015 and will remain in effect except with respect to any changes in its provisions in the future, which will be in effect immediately after being posted on this page.
        <br><br>
        We reserve the right to update or change our Privacy Policy at any time and you should check this Privacy Policy periodically. Your continued use of the Service after we post any modifications to the Privacy Policy on this page will constitute your acknowledgment of the modifications and your consent to abide and be bound by the modified Privacy Policy.
        <br><br>
        If we make any material changes to this Privacy Policy, we will notify you either through the email address you have provided us, or by placing a prominent notice on our Website.
    </p>
</div>
@endsection

@push('seo')
    <!-- generic meta tags -->
    <title>Privacy Policy | PurpleBug</title>
    <meta name="description" content="Privacy Policy | PurpleBug">
    <meta name="keywords" content="Privacy Policy,PurpleBug">
@endpush