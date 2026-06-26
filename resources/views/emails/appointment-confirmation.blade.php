<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Booking Confirmed — BookEase</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { background: #f8f9ff; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif; color: #0b1c30; }
        .wrapper { max-width: 580px; margin: 40px auto; padding: 0 16px 40px; }
        .card { background: #ffffff; border-radius: 16px; overflow: hidden; box-shadow: 0 2px 12px rgba(0,0,0,0.08); }

        /* Header */
        .header { background: linear-gradient(135deg, #864461 0%, #5a2a3e 100%); padding: 36px 40px; }
        .header-logo { display: flex; align-items: center; gap: 10px; margin-bottom: 24px; }
        .header-logo-icon { width: 40px; height: 40px; background: rgba(255,255,255,0.15); border-radius: 12px;
                            display: flex; align-items: center; justify-content: center;
                            font-size: 20px; color: white; font-weight: 700; }
        .header-logo-text { color: white; font-size: 18px; font-weight: 700; letter-spacing: -0.02em; }
        .header-badge { display: inline-flex; align-items: center; gap: 6px; background: rgba(255,255,255,0.15);
                        padding: 6px 14px; border-radius: 999px; color: white; font-size: 12px; font-weight: 600;
                        letter-spacing: 0.04em; text-transform: uppercase; margin-bottom: 12px; }
        .header-title { color: white; font-size: 26px; font-weight: 800; letter-spacing: -0.02em; line-height: 1.2; }
        .header-sub { color: rgba(255,209,225,0.85); font-size: 14px; margin-top: 6px; }

        /* Body */
        .body { padding: 32px 40px; }
        .greeting { font-size: 15px; color: #514348; margin-bottom: 24px; line-height: 1.6; }
        .greeting strong { color: #0b1c30; }

        /* Details card */
        .details { background: #f8f9ff; border: 1px solid #d3e4fe; border-radius: 12px; overflow: hidden; margin-bottom: 24px; }
        .details-header { background: #eddfe4; padding: 12px 20px; font-size: 11px; font-weight: 700;
                          text-transform: uppercase; letter-spacing: 0.06em; color: #864461; }
        .details-row { display: flex; align-items: flex-start; padding: 14px 20px; border-bottom: 1px solid #eff4ff; }
        .details-row:last-child { border-bottom: none; }
        .details-icon { width: 32px; height: 32px; background: #ffd9e5; border-radius: 8px;
                        display: flex; align-items: center; justify-content: center;
                        font-size: 16px; margin-right: 14px; flex-shrink: 0; }
        .details-label { font-size: 11px; font-weight: 600; text-transform: uppercase;
                         letter-spacing: 0.05em; color: #847378; margin-bottom: 2px; }
        .details-value { font-size: 14px; font-weight: 600; color: #0b1c30; }

        /* Info box */
        .info-box { background: #bcedda; border: 1px solid #a0d1bf; border-radius: 10px;
                    padding: 14px 18px; margin-bottom: 28px; display: flex; align-items: flex-start; gap: 10px; }
        .info-icon { font-size: 18px; flex-shrink: 0; margin-top: 1px; }
        .info-text { font-size: 13px; color: #002118; line-height: 1.5; }

        /* CTA */
        .cta-wrap { text-align: center; margin-bottom: 28px; }
        .cta { display: inline-block; background: #864461; color: white; text-decoration: none;
               padding: 14px 36px; border-radius: 12px; font-size: 14px; font-weight: 700;
               letter-spacing: 0.01em; }

        /* Footer */
        .divider { border: none; border-top: 1px solid #eff4ff; margin: 0; }
        .footer { padding: 24px 40px; }
        .footer-text { font-size: 12px; color: #847378; line-height: 1.7; }
        .footer-text a { color: #864461; text-decoration: none; }
        .footer-brand { margin-top: 20px; font-size: 12px; color: #d6c1c7; text-align: center; }
    </style>
</head>
<body>
<div class="wrapper">
<div class="card">

    {{-- Header --}}
    <div class="header">
        <div class="header-logo">
            <div class="header-logo-icon">B</div>
            <span class="header-logo-text">BookEase</span>
        </div>
        <div class="header-badge">✓ &nbsp;Booking Confirmed</div>
        <div class="header-title">You're all set!</div>
        <div class="header-sub">Your appointment has been confirmed.</div>
    </div>

    {{-- Body --}}
    <div class="body">

        <p class="greeting">
            Hi <strong>{{ $appointment->customer->name }}</strong>,<br>
            Your booking is confirmed. Here are the details:
        </p>

        {{-- Booking details --}}
        <div class="details">
            <div class="details-header">Appointment Details</div>

            <div class="details-row">
                <div class="details-icon">📅</div>
                <div>
                    <div class="details-label">Date</div>
                    <div class="details-value">{{ $appointment->starts_at->format('l, F j, Y') }}</div>
                </div>
            </div>

            <div class="details-row">
                <div class="details-icon">🕐</div>
                <div>
                    <div class="details-label">Time</div>
                    <div class="details-value">
                        {{ $appointment->starts_at->format('g:i A') }} – {{ $appointment->ends_at->format('g:i A') }}
                    </div>
                </div>
            </div>

            <div class="details-row">
                <div class="details-icon">✂️</div>
                <div>
                    <div class="details-label">Service</div>
                    <div class="details-value">
                        {{ $appointment->service->name }}
                        <span style="color:#847378; font-weight:400;"> · {{ $appointment->service->duration_minutes }} min</span>
                    </div>
                </div>
            </div>

            <div class="details-row">
                <div class="details-icon">👤</div>
                <div>
                    <div class="details-label">Staff Member</div>
                    <div class="details-value">{{ $appointment->staff->user->name }}</div>
                </div>
            </div>

            @if($appointment->notes)
            <div class="details-row">
                <div class="details-icon">📝</div>
                <div>
                    <div class="details-label">Notes</div>
                    <div class="details-value" style="font-weight:400; color:#514348;">{{ $appointment->notes }}</div>
                </div>
            </div>
            @endif
        </div>

        {{-- Cancellation notice --}}
        <div class="info-box">
            <span class="info-icon">ℹ️</span>
            <p class="info-text">
                Need to cancel? You can cancel your appointment up to <strong>2 hours before</strong> the scheduled time from your bookings page.
            </p>
        </div>

        {{-- CTA --}}
        <div class="cta-wrap">
            <a href="{{ url('/my-bookings') }}" class="cta">View My Bookings</a>
        </div>

    </div>

    <hr class="divider">

    {{-- Footer --}}
    <div class="footer">
        <p class="footer-text">
            This email was sent because an appointment was booked on your BookEase account.
            If you didn't make this booking, please contact us immediately.
        </p>
        <p class="footer-brand">© {{ date('Y') }} BookEase — Appointments, simplified.</p>
    </div>

</div>
</div>
</body>
</html>
