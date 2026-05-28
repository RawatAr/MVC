<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>URGENT: Blood Donation Needed</title>
</head>
<body style="font-family: Arial, sans-serif; background-color: #f6f9fc; padding: 20px; color: #333;">
    <div style="max-width: 600px; margin: 0 auto; background-color: #ffffff; border-radius: 8px; border: 1px solid #e2e8f0; overflow: hidden; box-shadow: 0 4px 6px rgba(0,0,0,0.05);">
        <!-- Banner -->
        <div style="background-color: #ef4444; padding: 30px; text-align: center;">
            <h1 style="color: #ffffff; margin: 0; font-size: 24px; font-weight: bold;">EMERGENCY BLOOD ALERT</h1>
        </div>
        
        <!-- Content -->
        <div style="padding: 30px;">
            <p style="font-size: 16px; line-height: 1.5; margin-top: 0;">Dear {{ $donor->name }},</p>
            
            <p style="font-size: 15px; line-height: 1.5;">An urgent request for blood donation has been raised in your city (<strong>{{ $bloodRequest->city }}</strong>) that matches your blood group (<strong>{{ $bloodRequest->blood_group }}</strong>).</p>
            
            <!-- Details Box -->
            <div style="background-color: #f8fafc; border-left: 4px solid #ef4444; padding: 20px; margin: 25px 0; border-radius: 4px;">
                <table style="width: 100%; border-collapse: collapse;">
                    <tr>
                        <td style="padding: 6px 0; color: #64748b; font-size: 14px;">Patient Name</td>
                        <td style="padding: 6px 0; font-weight: bold; color: #1e293b;">{{ $bloodRequest->requester_name }}</td>
                    </tr>
                    <tr>
                        <td style="padding: 6px 0; color: #64748b; font-size: 14px;">Blood Group Needed</td>
                        <td style="padding: 6px 0; font-weight: bold; color: #ef4444; font-size: 16px;">{{ $bloodRequest->blood_group }}</td>
                    </tr>
                    <tr>
                        <td style="padding: 6px 0; color: #64748b; font-size: 14px;">Units Needed</td>
                        <td style="padding: 6px 0; font-weight: bold; color: #1e293b;">{{ $bloodRequest->units_needed }} Unit(s)</td>
                    </tr>
                    <tr>
                        <td style="padding: 6px 0; color: #64748b; font-size: 14px;">Hospital / Venue</td>
                        <td style="padding: 6px 0; font-weight: bold; color: #1e293b;">{{ $bloodRequest->hospital }}</td>
                    </tr>
                    <tr>
                        <td style="padding: 6px 0; color: #64748b; font-size: 14px;">City / Locality</td>
                        <td style="padding: 6px 0; font-weight: bold; color: #1e293b;">{{ $bloodRequest->city }}</td>
                    </tr>
                </table>
            </div>

            <p style="font-size: 15px; line-height: 1.5; margin-bottom: 30px;">If you are available to donate, please click the button below to view the tracking details and contact the requester.</p>
            
            <!-- Button -->
            <div style="text-align: center; margin-bottom: 30px;">
                <a href="{{ route('request.track', $bloodRequest->id) }}" style="background-color: #ef4444; color: #ffffff; text-decoration: none; padding: 12px 30px; font-weight: bold; border-radius: 6px; display: inline-block; box-shadow: 0 4px 6px rgba(239,68,68,0.2);">Respond to Requisition</a>
            </div>
            
            <p style="font-size: 14px; line-height: 1.5; color: #64748b; margin-bottom: 0;">Thank you for being a part of the BloodLink community. You are saving lives.</p>
        </div>
        
        <!-- Footer -->
        <div style="background-color: #f1f5f9; padding: 20px; text-align: center; font-size: 12px; color: #64748b; border-top: 1px solid #e2e8f0;">
            <p style="margin: 0 0 5px 0;">This is an automated alert sent by BloodLink.</p>
            <p style="margin: 0;">INT221 MVC Programming (Laravel) Course Project</p>
        </div>
    </div>
</body>
</html>
