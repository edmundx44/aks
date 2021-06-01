function get_payment_fees()
{
	var infinity = 9007199254740992
	var shops = [13,61616,17,47,31,733,73,94,100,72,40,122,701,218,227,272,162,317,315,318,158,163,307,178,67,212,704,323,174,224,176,400];
	fees = {};

	for (var index in shops)
	{
		var shop = shops[index];
		fees[shop] = {};
		fees[shop]['paypal'] = {};
		fees[shop]['card'] = {};

		
		if (shop == 13 )
		{
			fees[shop]['paypal'][10] = {};
			fees[shop]['paypal'][10]['a'] = 1.03;
			fees[shop]['paypal'][10]['b'] = 0;
			fees[shop]['paypal'][20] = {};
			fees[shop]['paypal'][20]['a'] = 1.03;
			fees[shop]['paypal'][20]['b'] = 0;
			fees[shop]['paypal'][30] = {};
			fees[shop]['paypal'][30]['a'] = 1.03;
			fees[shop]['paypal'][30]['b'] = 0;
			fees[shop]['paypal'][infinity] = {};
			fees[shop]['paypal'][infinity]['a'] = 1.03;
			fees[shop]['paypal'][infinity]['b'] = 0;
			fees[shop]['card'][10] = {};
			fees[shop]['card'][10]['a'] = 1;
			fees[shop]['card'][10]['b'] = 0;
			fees[shop]['card'][20] = {};
			fees[shop]['card'][20]['a'] = 1;
			fees[shop]['card'][20]['b'] = 0;
			fees[shop]['card'][30] = {};
			fees[shop]['card'][30]['a'] = 1;
			fees[shop]['card'][30]['b'] = 0;
			fees[shop]['card'][infinity] = {};
			fees[shop]['card'][infinity]['a'] = 1;
			fees[shop]['card'][infinity]['b'] = 0;
		}

		if (shop == 61616 )
		{
			fees[shop]['paypal'][10] = {};
			fees[shop]['paypal'][10]['a'] = 1;
			fees[shop]['paypal'][10]['b'] = 1.99;
			fees[shop]['paypal'][20] = {};
			fees[shop]['paypal'][20]['a'] = 1;
			fees[shop]['paypal'][20]['b'] = 1.99;
			fees[shop]['paypal'][30] = {};
			fees[shop]['paypal'][30]['a'] = 1;
			fees[shop]['paypal'][30]['b'] = 1.99;
			fees[shop]['paypal'][infinity] = {};
			fees[shop]['paypal'][infinity]['a'] = 1;
			fees[shop]['paypal'][infinity]['b'] = 1.99;
			fees[shop]['card'][10] = {};
			fees[shop]['card'][10]['a'] = 1;
			fees[shop]['card'][10]['b'] = 1.99;
			fees[shop]['card'][20] = {};
			fees[shop]['card'][20]['a'] = 1;
			fees[shop]['card'][20]['b'] = 1.99;
			fees[shop]['card'][30] = {};
			fees[shop]['card'][30]['a'] = 1;
			fees[shop]['card'][30]['b'] = 1.99;
			fees[shop]['card'][infinity] = {};
			fees[shop]['card'][infinity]['a'] = 1;
			fees[shop]['card'][infinity]['b'] = 1.99;
		}

		if (shop == 17 )
		{
			fees[shop]['paypal'][10] = {};
			fees[shop]['paypal'][10]['a'] = 1;
			fees[shop]['paypal'][10]['b'] = 0;
			fees[shop]['paypal'][20] = {};
			fees[shop]['paypal'][20]['a'] = 1;
			fees[shop]['paypal'][20]['b'] = 0;
			fees[shop]['paypal'][30] = {};
			fees[shop]['paypal'][30]['a'] = 1;
			fees[shop]['paypal'][30]['b'] = 0;
			fees[shop]['paypal'][infinity] = {};
			fees[shop]['paypal'][infinity]['a'] = 1;
			fees[shop]['paypal'][infinity]['b'] = 0;
			fees[shop]['card'][10] = {};
			fees[shop]['card'][10]['a'] = 1;
			fees[shop]['card'][10]['b'] = 0;
			fees[shop]['card'][20] = {};
			fees[shop]['card'][20]['a'] = 1;
			fees[shop]['card'][20]['b'] = 0;
			fees[shop]['card'][30] = {};
			fees[shop]['card'][30]['a'] = 1;
			fees[shop]['card'][30]['b'] = 0;
			fees[shop]['card'][infinity] = {};
			fees[shop]['card'][infinity]['a'] = 1;
			fees[shop]['card'][infinity]['b'] = 0;
		}

		if (shop == 47 )
		{
			fees[shop]['paypal'][2] = {};
			fees[shop]['paypal'][2]['a'] = 1.05;
			fees[shop]['paypal'][2]['b'] = 0.35;
			fees[shop]['paypal'][5] = {};
			fees[shop]['paypal'][5]['a'] = 1.08;
			fees[shop]['paypal'][5]['b'] = 0.35;
			fees[shop]['paypal'][10] = {};
			fees[shop]['paypal'][10]['a'] = 1.124;
			fees[shop]['paypal'][10]['b'] = 0.43;
			fees[shop]['paypal'][15] = {};
			fees[shop]['paypal'][15]['a'] = 1.114;
			fees[shop]['paypal'][15]['b'] = 0.35;
			fees[shop]['paypal'][20] = {};
			fees[shop]['paypal'][20]['a'] = 1.104;
			fees[shop]['paypal'][20]['b'] = 0.35;
			fees[shop]['paypal'][25] = {};
			fees[shop]['paypal'][25]['a'] = 1.104;
			fees[shop]['paypal'][25]['b'] = 0.55;
			fees[shop]['paypal'][40] = {};
			fees[shop]['paypal'][40]['a'] = 1.079;
			fees[shop]['paypal'][40]['b'] = 0.35;
			fees[shop]['paypal'][infinity] = {};
			fees[shop]['paypal'][infinity]['a'] = 1.0514;
			fees[shop]['paypal'][infinity]['b'] = 0;
			fees[shop]['card'][2] = {};
			fees[shop]['card'][2]['a'] = 1.075;
			fees[shop]['card'][2]['b'] = 0;
			fees[shop]['card'][5] = {};
			fees[shop]['card'][5]['a'] = 1.105;
			fees[shop]['card'][5]['b'] = 0;
			fees[shop]['card'][10] = {};
			fees[shop]['card'][10]['a'] = 1.125;
			fees[shop]['card'][10]['b'] = 0.08;
			fees[shop]['card'][15] = {};
			fees[shop]['card'][15]['a'] = 1.115;
			fees[shop]['card'][15]['b'] = 0;
			fees[shop]['card'][20] = {};
			fees[shop]['card'][20]['a'] = 1.105;
			fees[shop]['card'][20]['b'] = 0.2;
			fees[shop]['card'][30] = {};
			fees[shop]['card'][30]['a'] = 1.08;
			fees[shop]['card'][30]['b'] = 0.04;
			fees[shop]['card'][40] = {};
			fees[shop]['card'][40]['a'] = 1.03;
			fees[shop]['card'][40]['b'] = 0;
			fees[shop]['card'][infinity] = {};
			fees[shop]['card'][infinity]['a'] = 1.046;
			fees[shop]['card'][infinity]['b'] = 0.3;
		}

		if (shop == 31 )
		{
			fees[shop]['paypal'][10] = {};
			fees[shop]['paypal'][10]['a'] = 1.05;
			fees[shop]['paypal'][10]['b'] = 0.87;
			fees[shop]['paypal'][20] = {};
			fees[shop]['paypal'][20]['a'] = 1.03;
			fees[shop]['paypal'][20]['b'] = 0.9;
			fees[shop]['paypal'][30] = {};
			fees[shop]['paypal'][30]['a'] = 1.03;
			fees[shop]['paypal'][30]['b'] = 0.85;
			fees[shop]['paypal'][infinity] = {};
			fees[shop]['paypal'][infinity]['a'] = 1.025;
			fees[shop]['paypal'][infinity]['b'] = 0.52;
			fees[shop]['card'][10] = {};
			fees[shop]['card'][10]['a'] = 1.03;
			fees[shop]['card'][10]['b'] = 0.4;
			fees[shop]['card'][20] = {};
			fees[shop]['card'][20]['a'] = 1.03;
			fees[shop]['card'][20]['b'] = 0.4;
			fees[shop]['card'][30] = {};
			fees[shop]['card'][30]['a'] = 1.03;
			fees[shop]['card'][30]['b'] = 0.4;
			fees[shop]['card'][infinity] = {};
			fees[shop]['card'][infinity]['a'] = 1.03;
			fees[shop]['card'][infinity]['b'] = 0.4;
		}

		if (shop == 733 )
		{
			fees[shop]['paypal'][10] = {};
			fees[shop]['paypal'][10]['a'] = 1.03124;
			fees[shop]['paypal'][10]['b'] = 0;
			fees[shop]['paypal'][20] = {};
			fees[shop]['paypal'][20]['a'] = 1.05;
			fees[shop]['paypal'][20]['b'] = 0;
			fees[shop]['paypal'][30] = {};
			fees[shop]['paypal'][30]['a'] = 1.05;
			fees[shop]['paypal'][30]['b'] = 0;
			fees[shop]['paypal'][infinity] = {};
			fees[shop]['paypal'][infinity]['a'] = 1.05;
			fees[shop]['paypal'][infinity]['b'] = 0;
			fees[shop]['card'][10] = {};
			fees[shop]['card'][10]['a'] = 1.03124;
			fees[shop]['card'][10]['b'] = 0;
			fees[shop]['card'][20] = {};
			fees[shop]['card'][20]['a'] = 1.05;
			fees[shop]['card'][20]['b'] = 0;
			fees[shop]['card'][30] = {};
			fees[shop]['card'][30]['a'] = 1.05;
			fees[shop]['card'][30]['b'] = 0;
			fees[shop]['card'][infinity] = {};
			fees[shop]['card'][infinity]['a'] = 1.05;
			fees[shop]['card'][infinity]['b'] = 0;
		}

		if (shop == 73 )
		{
			fees[shop]['paypal'][10] = {};
			fees[shop]['paypal'][10]['a'] = 1.05;
			fees[shop]['paypal'][10]['b'] = 0.01;
			fees[shop]['paypal'][20] = {};
			fees[shop]['paypal'][20]['a'] = 1.05;
			fees[shop]['paypal'][20]['b'] = 0.06;
			fees[shop]['paypal'][30] = {};
			fees[shop]['paypal'][30]['a'] = 1.05;
			fees[shop]['paypal'][30]['b'] = 0.06;
			fees[shop]['paypal'][infinity] = {};
			fees[shop]['paypal'][infinity]['a'] = 1.05;
			fees[shop]['paypal'][infinity]['b'] = 0.06;
			fees[shop]['card'][10] = {};
			fees[shop]['card'][10]['a'] = 1.05;
			fees[shop]['card'][10]['b'] = 0.01;
			fees[shop]['card'][20] = {};
			fees[shop]['card'][20]['a'] = 1.05;
			fees[shop]['card'][20]['b'] = 0.06;
			fees[shop]['card'][30] = {};
			fees[shop]['card'][30]['a'] = 1.05;
			fees[shop]['card'][30]['b'] = 0.06;
			fees[shop]['card'][infinity] = {};
			fees[shop]['card'][infinity]['a'] = 1.05;
			fees[shop]['card'][infinity]['b'] = 0.06;
		}

		if (shop == 94 )
		{
			fees[shop]['paypal'][10] = {};
			fees[shop]['paypal'][10]['a'] = 1.0799;
			fees[shop]['paypal'][10]['b'] = 0.44;
			fees[shop]['paypal'][20] = {};
			fees[shop]['paypal'][20]['a'] = 1.04;
			fees[shop]['paypal'][20]['b'] = 1.24;
			fees[shop]['paypal'][30] = {};
			fees[shop]['paypal'][30]['a'] = 1.0566;
			fees[shop]['paypal'][30]['b'] = 1.05;
			fees[shop]['paypal'][infinity] = {};
			fees[shop]['paypal'][infinity]['a'] = 1.05;
			fees[shop]['paypal'][infinity]['b'] = 1;
			fees[shop]['card'][10] = {};
			fees[shop]['card'][10]['a'] = 1.0799;
			fees[shop]['card'][10]['b'] = 0.44;
			fees[shop]['card'][20] = {};
			fees[shop]['card'][20]['a'] = 1.04;
			fees[shop]['card'][20]['b'] = 1.24;
			fees[shop]['card'][30] = {};
			fees[shop]['card'][30]['a'] = 1.0566;
			fees[shop]['card'][30]['b'] = 1.04;
			fees[shop]['card'][infinity] = {};
			fees[shop]['card'][infinity]['a'] = 1.05;
			fees[shop]['card'][infinity]['b'] = 1;
		}

		if (shop == 100 )
		{
			fees[shop]['paypal'][10] = {};
			fees[shop]['paypal'][10]['a'] = 1;
			fees[shop]['paypal'][10]['b'] = 0;
			fees[shop]['paypal'][20] = {};
			fees[shop]['paypal'][20]['a'] = 1;
			fees[shop]['paypal'][20]['b'] = 0;
			fees[shop]['paypal'][30] = {};
			fees[shop]['paypal'][30]['a'] = 1;
			fees[shop]['paypal'][30]['b'] = 0;
			fees[shop]['paypal'][infinity] = {};
			fees[shop]['paypal'][infinity]['a'] = 1;
			fees[shop]['paypal'][infinity]['b'] = 0;
			fees[shop]['card'][10] = {};
			fees[shop]['card'][10]['a'] = 1;
			fees[shop]['card'][10]['b'] = 0;
			fees[shop]['card'][20] = {};
			fees[shop]['card'][20]['a'] = 1;
			fees[shop]['card'][20]['b'] = 0;
			fees[shop]['card'][30] = {};
			fees[shop]['card'][30]['a'] = 1;
			fees[shop]['card'][30]['b'] = 0;
			fees[shop]['card'][infinity] = {};
			fees[shop]['card'][infinity]['a'] = 1.038;
			fees[shop]['card'][infinity]['b'] = 0;
		}

		if (shop == 72 )
		{
			fees[shop]['paypal'][10] = {};
			fees[shop]['paypal'][10]['a'] = 1;
			fees[shop]['paypal'][10]['b'] = 0;
			fees[shop]['paypal'][20] = {};
			fees[shop]['paypal'][20]['a'] = 1;
			fees[shop]['paypal'][20]['b'] = 0;
			fees[shop]['paypal'][30] = {};
			fees[shop]['paypal'][30]['a'] = 1;
			fees[shop]['paypal'][30]['b'] = 0;
			fees[shop]['paypal'][infinity] = {};
			fees[shop]['paypal'][infinity]['a'] = 1.03;
			fees[shop]['paypal'][infinity]['b'] = 0.5;
			fees[shop]['card'][10] = {};
			fees[shop]['card'][10]['a'] = 1;
			fees[shop]['card'][10]['b'] = 0;
			fees[shop]['card'][20] = {};
			fees[shop]['card'][20]['a'] = 1;
			fees[shop]['card'][20]['b'] = 0;
			fees[shop]['card'][30] = {};
			fees[shop]['card'][30]['a'] = 1;
			fees[shop]['card'][30]['b'] = 0;
			fees[shop]['card'][infinity] = {};
			fees[shop]['card'][infinity]['a'] = 1.01;
			fees[shop]['card'][infinity]['b'] = 0;
		}

		if (shop == 40 )
		{
			fees[shop]['paypal'][10] = {};
			fees[shop]['paypal'][10]['a'] = 1;
			fees[shop]['paypal'][10]['b'] = 0;
			fees[shop]['paypal'][20] = {};
			fees[shop]['paypal'][20]['a'] = 1;
			fees[shop]['paypal'][20]['b'] = 0;
			fees[shop]['paypal'][30] = {};
			fees[shop]['paypal'][30]['a'] = 1;
			fees[shop]['paypal'][30]['b'] = 0;
			fees[shop]['paypal'][infinity] = {};
			fees[shop]['paypal'][infinity]['a'] = 1;
			fees[shop]['paypal'][infinity]['b'] = 0;
			fees[shop]['card'][10] = {};
			fees[shop]['card'][10]['a'] = 1.01;
			fees[shop]['card'][10]['b'] = 0;
			fees[shop]['card'][20] = {};
			fees[shop]['card'][20]['a'] = 1;
			fees[shop]['card'][20]['b'] = 0;
			fees[shop]['card'][30] = {};
			fees[shop]['card'][30]['a'] = 1;
			fees[shop]['card'][30]['b'] = 0;
			fees[shop]['card'][infinity] = {};
			fees[shop]['card'][infinity]['a'] = 1.01;
			fees[shop]['card'][infinity]['b'] = 0;
		}

		if (shop == 122 )
		{
			fees[shop]['paypal'][10] = {};
			fees[shop]['paypal'][10]['a'] = 1.03;
			fees[shop]['paypal'][10]['b'] = 0.34;
			fees[shop]['paypal'][20] = {};
			fees[shop]['paypal'][20]['a'] = 1.03;
			fees[shop]['paypal'][20]['b'] = 0.33;
			fees[shop]['paypal'][30] = {};
			fees[shop]['paypal'][30]['a'] = 1.03;
			fees[shop]['paypal'][30]['b'] = 0.32;
			fees[shop]['paypal'][infinity] = {};
			fees[shop]['paypal'][infinity]['a'] = 1.03;
			fees[shop]['paypal'][infinity]['b'] = 0.32;
			fees[shop]['card'][10] = {};
			fees[shop]['card'][10]['a'] = 1.12;
			fees[shop]['card'][10]['b'] = 0.21;
			fees[shop]['card'][20] = {};
			fees[shop]['card'][20]['a'] = 1.051;
			fees[shop]['card'][20]['b'] = 0;
			fees[shop]['card'][30] = {};
			fees[shop]['card'][30]['a'] = 1.03;
			fees[shop]['card'][30]['b'] = 0.3;
			fees[shop]['card'][infinity] = {};
			fees[shop]['card'][infinity]['a'] = 1.03;
			fees[shop]['card'][infinity]['b'] = 0.3;
		}

		if (shop == 701 )
		{
			fees[shop]['paypal'][10] = {};
			fees[shop]['paypal'][10]['a'] = 1;
			fees[shop]['paypal'][10]['b'] = 0;
			fees[shop]['paypal'][20] = {};
			fees[shop]['paypal'][20]['a'] = 1;
			fees[shop]['paypal'][20]['b'] = 0;
			fees[shop]['paypal'][30] = {};
			fees[shop]['paypal'][30]['a'] = 1;
			fees[shop]['paypal'][30]['b'] = 0;
			fees[shop]['paypal'][infinity] = {};
			fees[shop]['paypal'][infinity]['a'] = 1;
			fees[shop]['paypal'][infinity]['b'] = 0;
			fees[shop]['card'][10] = {};
			fees[shop]['card'][10]['a'] = 1;
			fees[shop]['card'][10]['b'] = 0;
			fees[shop]['card'][20] = {};
			fees[shop]['card'][20]['a'] = 1;
			fees[shop]['card'][20]['b'] = 0;
			fees[shop]['card'][30] = {};
			fees[shop]['card'][30]['a'] = 1;
			fees[shop]['card'][30]['b'] = 0;
			fees[shop]['card'][infinity] = {};
			fees[shop]['card'][infinity]['a'] = 1;
			fees[shop]['card'][infinity]['b'] = 0;
		}

		if (shop == 218 )
		{
			fees[shop]['paypal'][10] = {};
			fees[shop]['paypal'][10]['a'] = 1.035;
			fees[shop]['paypal'][10]['b'] = 0.53;
			fees[shop]['paypal'][20] = {};
			fees[shop]['paypal'][20]['a'] = 1.035;
			fees[shop]['paypal'][20]['b'] = 0.56;
			fees[shop]['paypal'][30] = {};
			fees[shop]['paypal'][30]['a'] = 1.035;
			fees[shop]['paypal'][30]['b'] = 0.56;
			fees[shop]['paypal'][infinity] = {};
			fees[shop]['paypal'][infinity]['a'] = 1.035;
			fees[shop]['paypal'][infinity]['b'] = 0.55;
			fees[shop]['card'][10] = {};
			fees[shop]['card'][10]['a'] = 1.03;
			fees[shop]['card'][10]['b'] = 0.53;
			fees[shop]['card'][20] = {};
			fees[shop]['card'][20]['a'] = 1.035;
			fees[shop]['card'][20]['b'] = 0.56;
			fees[shop]['card'][30] = {};
			fees[shop]['card'][30]['a'] = 1.03;
			fees[shop]['card'][30]['b'] = 0.43;
			fees[shop]['card'][infinity] = {};
			fees[shop]['card'][infinity]['a'] = 1.035;
			fees[shop]['card'][infinity]['b'] = 0.55;
		}

		if (shop == 227 )
		{
			fees[shop]['paypal'][10] = {};
			fees[shop]['paypal'][10]['a'] = 1;
			fees[shop]['paypal'][10]['b'] = 0;
			fees[shop]['paypal'][20] = {};
			fees[shop]['paypal'][20]['a'] = 1;
			fees[shop]['paypal'][20]['b'] = 0;
			fees[shop]['paypal'][30] = {};
			fees[shop]['paypal'][30]['a'] = 1;
			fees[shop]['paypal'][30]['b'] = 0;
			fees[shop]['paypal'][infinity] = {};
			fees[shop]['paypal'][infinity]['a'] = 1;
			fees[shop]['paypal'][infinity]['b'] = 0;
			fees[shop]['card'][10] = {};
			fees[shop]['card'][10]['a'] = 1.018;
			fees[shop]['card'][10]['b'] = 0;
			fees[shop]['card'][20] = {};
			fees[shop]['card'][20]['a'] = 1.018;
			fees[shop]['card'][20]['b'] = 0;
			fees[shop]['card'][30] = {};
			fees[shop]['card'][30]['a'] = 1.018;
			fees[shop]['card'][30]['b'] = 0;
			fees[shop]['card'][infinity] = {};
			fees[shop]['card'][infinity]['a'] = 1.018;
			fees[shop]['card'][infinity]['b'] = 0;
		}

		if (shop == 272 )
		{
			fees[shop]['paypal'][10] = {};
			fees[shop]['paypal'][10]['a'] = 1.055;
			fees[shop]['paypal'][10]['b'] = 0.35;
			fees[shop]['paypal'][20] = {};
			fees[shop]['paypal'][20]['a'] = 1.055;
			fees[shop]['paypal'][20]['b'] = 0.35;
			fees[shop]['paypal'][30] = {};
			fees[shop]['paypal'][30]['a'] = 1.055;
			fees[shop]['paypal'][30]['b'] = 0.35;
			fees[shop]['paypal'][infinity] = {};
			fees[shop]['paypal'][infinity]['a'] = 1.055;
			fees[shop]['paypal'][infinity]['b'] = 0.60;
			fees[shop]['card'][10] = {};
			fees[shop]['card'][10]['a'] = 1.055;
			fees[shop]['card'][10]['b'] = 0.35;
			fees[shop]['card'][20] = {};
			fees[shop]['card'][20]['a'] = 1.055;
			fees[shop]['card'][20]['b'] = 0.35;
			fees[shop]['card'][30] = {};
			fees[shop]['card'][30]['a'] = 1.055;
			fees[shop]['card'][30]['b'] = 0.35;
			fees[shop]['card'][infinity] = {};
			fees[shop]['card'][infinity]['a'] = 1.055;
			fees[shop]['card'][infinity]['b'] = 0.60;
		}

		if (shop == 162 )
		{
			fees[shop]['paypal'][10] = {};
			fees[shop]['paypal'][10]['a'] = 1.029;
			fees[shop]['paypal'][10]['b'] = 0.35;
			fees[shop]['paypal'][20] = {};
			fees[shop]['paypal'][20]['a'] = 1.029;
			fees[shop]['paypal'][20]['b'] = 0.35;
			fees[shop]['paypal'][30] = {};
			fees[shop]['paypal'][30]['a'] = 1.029;
			fees[shop]['paypal'][30]['b'] = 0.35;
			fees[shop]['paypal'][infinity] = {};
			fees[shop]['paypal'][infinity]['a'] = 1.029;
			fees[shop]['paypal'][infinity]['b'] = 0.35;
			fees[shop]['card'][10] = {};
			fees[shop]['card'][10]['a'] = 1.029;
			fees[shop]['card'][10]['b'] = 0.35;
			fees[shop]['card'][20] = {};
			fees[shop]['card'][20]['a'] = 1.029;
			fees[shop]['card'][20]['b'] = 0.35;
			fees[shop]['card'][30] = {};
			fees[shop]['card'][30]['a'] = 1.029;
			fees[shop]['card'][30]['b'] = 0.35;
			fees[shop]['card'][infinity] = {};
			fees[shop]['card'][infinity]['a'] = 1.029;
			fees[shop]['card'][infinity]['b'] = 0.35;
		}

		if (shop == 317 )
		{
			fees[shop]['paypal'][10] = {};
			fees[shop]['paypal'][10]['a'] = 1.156;
			fees[shop]['paypal'][10]['b'] = 0;
			fees[shop]['paypal'][20] = {};
			fees[shop]['paypal'][20]['a'] = 1.066;
			fees[shop]['paypal'][20]['b'] = 0;
			fees[shop]['paypal'][30] = {};
			fees[shop]['paypal'][30]['a'] = 1.046;
			fees[shop]['paypal'][30]['b'] = 0;
			fees[shop]['paypal'][infinity] = {};
			fees[shop]['paypal'][infinity]['a'] = 1.046;
			fees[shop]['paypal'][infinity]['b'] = 0;
			fees[shop]['card'][10] = {};
			fees[shop]['card'][10]['a'] = 1.156;
			fees[shop]['card'][10]['b'] = 0;
			fees[shop]['card'][20] = {};
			fees[shop]['card'][20]['a'] = 1.066;
			fees[shop]['card'][20]['b'] = 0;
			fees[shop]['card'][30] = {};
			fees[shop]['card'][30]['a'] = 1.046;
			fees[shop]['card'][30]['b'] = 0;
			fees[shop]['card'][infinity] = {};
			fees[shop]['card'][infinity]['a'] = 1.046;
			fees[shop]['card'][infinity]['b'] = 0;
		}

		if (shop == 315 )
		{
			fees[shop]['paypal'][10] = {};
			fees[shop]['paypal'][10]['a'] = 1.04;
			fees[shop]['paypal'][10]['b'] = 0;
			fees[shop]['paypal'][20] = {};
			fees[shop]['paypal'][20]['a'] = 1.04;
			fees[shop]['paypal'][20]['b'] = 0;
			fees[shop]['paypal'][30] = {};
			fees[shop]['paypal'][30]['a'] = 1.04;
			fees[shop]['paypal'][30]['b'] = 0;
			fees[shop]['paypal'][infinity] = {};
			fees[shop]['paypal'][infinity]['a'] = 1.04;
			fees[shop]['paypal'][infinity]['b'] = 0;
			fees[shop]['card'][10] = {};
			fees[shop]['card'][10]['a'] = 1.04;
			fees[shop]['card'][10]['b'] = 0;
			fees[shop]['card'][20] = {};
			fees[shop]['card'][20]['a'] = 1.04;
			fees[shop]['card'][20]['b'] = 0;
			fees[shop]['card'][30] = {};
			fees[shop]['card'][30]['a'] = 1.04;
			fees[shop]['card'][30]['b'] = 0;
			fees[shop]['card'][infinity] = {};
			fees[shop]['card'][infinity]['a'] = 1.04;
			fees[shop]['card'][infinity]['b'] = 0;
		}

		if (shop == 318 )
		{
			fees[shop]['paypal'][10] = {};
			fees[shop]['paypal'][10]['a'] = 1.04;
			fees[shop]['paypal'][10]['b'] = 0;
			fees[shop]['paypal'][20] = {};
			fees[shop]['paypal'][20]['a'] = 1.04;
			fees[shop]['paypal'][20]['b'] = 0;
			fees[shop]['paypal'][30] = {};
			fees[shop]['paypal'][30]['a'] = 1.04;
			fees[shop]['paypal'][30]['b'] = 0;
			fees[shop]['paypal'][infinity] = {};
			fees[shop]['paypal'][infinity]['a'] = 1.04;
			fees[shop]['paypal'][infinity]['b'] = 0;
			fees[shop]['card'][10] = {};
			fees[shop]['card'][10]['a'] = 1.04;
			fees[shop]['card'][10]['b'] = 0;
			fees[shop]['card'][20] = {};
			fees[shop]['card'][20]['a'] = 1.04;
			fees[shop]['card'][20]['b'] = 0;
			fees[shop]['card'][30] = {};
			fees[shop]['card'][30]['a'] = 1.04;
			fees[shop]['card'][30]['b'] = 0;
			fees[shop]['card'][infinity] = {};
			fees[shop]['card'][infinity]['a'] = 1.04;
			fees[shop]['card'][infinity]['b'] = 0;
		}

		if (shop == 158 )
		{
			fees[shop]['paypal'][10] = {};
			fees[shop]['paypal'][10]['a'] = 1.035;
			fees[shop]['paypal'][10]['b'] = 0;
			fees[shop]['paypal'][20] = {};
			fees[shop]['paypal'][20]['a'] = 1.035;
			fees[shop]['paypal'][20]['b'] = 0;
			fees[shop]['paypal'][30] = {};
			fees[shop]['paypal'][30]['a'] = 1.035;
			fees[shop]['paypal'][30]['b'] = 0;
			fees[shop]['paypal'][infinity] = {};
			fees[shop]['paypal'][infinity]['a'] = 1.035;
			fees[shop]['paypal'][infinity]['b'] = 0.1;
			fees[shop]['card'][10] = {};
			fees[shop]['card'][10]['a'] = 1;
			fees[shop]['card'][10]['b'] = 0;
			fees[shop]['card'][20] = {};
			fees[shop]['card'][20]['a'] = 1;
			fees[shop]['card'][20]['b'] = 0;
			fees[shop]['card'][30] = {};
			fees[shop]['card'][30]['a'] = 1;
			fees[shop]['card'][30]['b'] = 0;
			fees[shop]['card'][infinity] = {};
			fees[shop]['card'][infinity]['a'] = 1;
			fees[shop]['card'][infinity]['b'] = 0;
		}

		if (shop == 163 )
		{
			fees[shop]['paypal'][10.99] = {};
			fees[shop]['paypal'][10.99]['a'] = 1;
			fees[shop]['paypal'][10.99]['b'] = 0;
			fees[shop]['paypal'][20.99] = {};
			fees[shop]['paypal'][20.99]['a'] = 1;
			fees[shop]['paypal'][20.99]['b'] = 0;
			fees[shop]['paypal'][30.99] = {};
			fees[shop]['paypal'][30.99]['a'] = 1;
			fees[shop]['paypal'][30.99]['b'] = 0;
			fees[shop]['paypal'][infinity] = {};
			fees[shop]['paypal'][infinity]['a'] = 1;
			fees[shop]['paypal'][infinity]['b'] = 0;
			fees[shop]['card'][10.99] = {};
			fees[shop]['card'][10.99]['a'] = 1;
			fees[shop]['card'][10.99]['b'] = 0;
			fees[shop]['card'][20.99] = {};
			fees[shop]['card'][20.99]['a'] = 1;
			fees[shop]['card'][20.99]['b'] = 0;
			fees[shop]['card'][30.99] = {};
			fees[shop]['card'][30.99]['a'] = 1;
			fees[shop]['card'][30.99]['b'] = 0;
			fees[shop]['card'][infinity] = {};
			fees[shop]['card'][infinity]['a'] = 1;
			fees[shop]['card'][infinity]['b'] = 0;
		}

		if (shop == 307 )
		{
			fees[shop]['paypal'][10] = {};
			fees[shop]['paypal'][10]['a'] = 1.02;
			fees[shop]['paypal'][10]['b'] = 0.2;
			fees[shop]['paypal'][20] = {};
			fees[shop]['paypal'][20]['a'] = 1.03;
			fees[shop]['paypal'][20]['b'] = 0.44;
			fees[shop]['paypal'][30] = {};
			fees[shop]['paypal'][30]['a'] = 1.03;
			fees[shop]['paypal'][30]['b'] = 0.44;
			fees[shop]['paypal'][infinity] = {};
			fees[shop]['paypal'][infinity]['a'] = 1.02;
			fees[shop]['paypal'][infinity]['b'] = 0.2;
			fees[shop]['card'][10] = {};
			fees[shop]['card'][10]['a'] = 1;
			fees[shop]['card'][10]['b'] = 0;
			fees[shop]['card'][20] = {};
			fees[shop]['card'][20]['a'] = 1;
			fees[shop]['card'][20]['b'] = 0;
			fees[shop]['card'][30] = {};
			fees[shop]['card'][30]['a'] = 1;
			fees[shop]['card'][30]['b'] = 0;
			fees[shop]['card'][infinity] = {};
			fees[shop]['card'][infinity]['a'] = 1;
			fees[shop]['card'][infinity]['b'] = 0;
		}

		if (shop == 178 )
		{
			fees[shop]['paypal'][10] = {};
			fees[shop]['paypal'][10]['a'] = 1.0317;
			fees[shop]['paypal'][10]['b'] = 0;
			fees[shop]['paypal'][20] = {};
			fees[shop]['paypal'][20]['a'] = 1.0317;
			fees[shop]['paypal'][20]['b'] = 0;
			fees[shop]['paypal'][30] = {};
			fees[shop]['paypal'][30]['a'] = 1.0317;
			fees[shop]['paypal'][30]['b'] = 0;
			fees[shop]['paypal'][infinity] = {};
			fees[shop]['paypal'][infinity]['a'] = 1.0317;
			fees[shop]['paypal'][infinity]['b'] = 0;
			fees[shop]['card'][10] = {};
			fees[shop]['card'][10]['a'] = 1.0317;
			fees[shop]['card'][10]['b'] = 0;
			fees[shop]['card'][20] = {};
			fees[shop]['card'][20]['a'] = 1.0317;
			fees[shop]['card'][20]['b'] = 0;
			fees[shop]['card'][30] = {};
			fees[shop]['card'][30]['a'] = 1.0317;
			fees[shop]['card'][30]['b'] = 0;
			fees[shop]['card'][infinity] = {};
			fees[shop]['card'][infinity]['a'] = 1.0317;
			fees[shop]['card'][infinity]['b'] = 0;
		}

		if (shop == 67 )
		{
			fees[shop]['paypal'][10] = {};
			fees[shop]['paypal'][10]['a'] = 1.05;
			fees[shop]['paypal'][10]['b'] = 0;
			fees[shop]['paypal'][20] = {};
			fees[shop]['paypal'][20]['a'] = 1.05;
			fees[shop]['paypal'][20]['b'] = 0;
			fees[shop]['paypal'][30] = {};
			fees[shop]['paypal'][30]['a'] = 1.05;
			fees[shop]['paypal'][30]['b'] = 0;
			fees[shop]['paypal'][infinity] = {};
			fees[shop]['paypal'][infinity]['a'] = 1.05;
			fees[shop]['paypal'][infinity]['b'] = 0;
			fees[shop]['card'][10] = {};
			fees[shop]['card'][10]['a'] = 1;
			fees[shop]['card'][10]['b'] = 0;
			fees[shop]['card'][20] = {};
			fees[shop]['card'][20]['a'] = 1;
			fees[shop]['card'][20]['b'] = 0;
			fees[shop]['card'][30] = {};
			fees[shop]['card'][30]['a'] = 1;
			fees[shop]['card'][30]['b'] = 0;
			fees[shop]['card'][infinity] = {};
			fees[shop]['card'][infinity]['a'] = 1;
			fees[shop]['card'][infinity]['b'] = 0;
		}

		if (shop == 212 )
		{
			fees[shop]['paypal'][10] = {};
			fees[shop]['paypal'][10]['a'] = 1.05;
			fees[shop]['paypal'][10]['b'] = 0;
			fees[shop]['paypal'][20] = {};
			fees[shop]['paypal'][20]['a'] = 1.05;
			fees[shop]['paypal'][20]['b'] = 0;
			fees[shop]['paypal'][30] = {};
			fees[shop]['paypal'][30]['a'] = 1.05;
			fees[shop]['paypal'][30]['b'] = 0;
			fees[shop]['paypal'][infinity] = {};
			fees[shop]['paypal'][infinity]['a'] = 1.05;
			fees[shop]['paypal'][infinity]['b'] = 0;
			fees[shop]['card'][10] = {};
			fees[shop]['card'][10]['a'] = 1;
			fees[shop]['card'][10]['b'] = 0;
			fees[shop]['card'][20] = {};
			fees[shop]['card'][20]['a'] = 1;
			fees[shop]['card'][20]['b'] = 0;
			fees[shop]['card'][30] = {};
			fees[shop]['card'][30]['a'] = 1;
			fees[shop]['card'][30]['b'] = 0;
			fees[shop]['card'][infinity] = {};
			fees[shop]['card'][infinity]['a'] = 1;
			fees[shop]['card'][infinity]['b'] = 0;
		}

		if (shop == 704 )
		{
			fees[shop]['paypal'][10] = {};
			fees[shop]['paypal'][10]['a'] = 1.05;
			fees[shop]['paypal'][10]['b'] = 0;
			fees[shop]['paypal'][20] = {};
			fees[shop]['paypal'][20]['a'] = 1.05;
			fees[shop]['paypal'][20]['b'] = 0;
			fees[shop]['paypal'][30] = {};
			fees[shop]['paypal'][30]['a'] = 1.05;
			fees[shop]['paypal'][30]['b'] = 0;
			fees[shop]['paypal'][infinity] = {};
			fees[shop]['paypal'][infinity]['a'] = 1.05;
			fees[shop]['paypal'][infinity]['b'] = 0;
			fees[shop]['card'][10] = {};
			fees[shop]['card'][10]['a'] = 1;
			fees[shop]['card'][10]['b'] = 0;
			fees[shop]['card'][20] = {};
			fees[shop]['card'][20]['a'] = 1;
			fees[shop]['card'][20]['b'] = 0;
			fees[shop]['card'][30] = {};
			fees[shop]['card'][30]['a'] = 1;
			fees[shop]['card'][30]['b'] = 0;
			fees[shop]['card'][infinity] = {};
			fees[shop]['card'][infinity]['a'] = 1;
			fees[shop]['card'][infinity]['b'] = 0;
		}

		if (shop == 323 )
		{
			fees[shop]['paypal'][10] = {};
			fees[shop]['paypal'][10]['a'] = 1;
			fees[shop]['paypal'][10]['b'] = 0;
			fees[shop]['paypal'][20] = {};
			fees[shop]['paypal'][20]['a'] = 1;
			fees[shop]['paypal'][20]['b'] = 0;
			fees[shop]['paypal'][30] = {};
			fees[shop]['paypal'][30]['a'] = 1;
			fees[shop]['paypal'][30]['b'] = 0;
			fees[shop]['paypal'][infinity] = {};
			fees[shop]['paypal'][infinity]['a'] = 1.028;
			fees[shop]['paypal'][infinity]['b'] = 0;
			fees[shop]['card'][10] = {};
			fees[shop]['card'][10]['a'] = 1.028;
			fees[shop]['card'][10]['b'] = 0;
			fees[shop]['card'][20] = {};
			fees[shop]['card'][20]['a'] = 1.028;
			fees[shop]['card'][20]['b'] = 0;
			fees[shop]['card'][30] = {};
			fees[shop]['card'][30]['a'] = 1.028;
			fees[shop]['card'][30]['b'] = 0;
			fees[shop]['card'][infinity] = {};
			fees[shop]['card'][infinity]['a'] = 1.028;
			fees[shop]['card'][infinity]['b'] = 0;
		}

		if (shop == 174 )
		{
			fees[shop]['paypal'][10] = {};
			fees[shop]['paypal'][10]['a'] = 1.06;
			fees[shop]['paypal'][10]['b'] = 0;
			fees[shop]['paypal'][20] = {};
			fees[shop]['paypal'][20]['a'] = 1.06;
			fees[shop]['paypal'][20]['b'] = 0;
			fees[shop]['paypal'][30] = {};
			fees[shop]['paypal'][30]['a'] = 1.06;
			fees[shop]['paypal'][30]['b'] = 0;
			fees[shop]['paypal'][infinity] = {};
			fees[shop]['paypal'][infinity]['a'] = 1.06;
			fees[shop]['paypal'][infinity]['b'] = 0;
			fees[shop]['card'][10] = {};
			fees[shop]['card'][10]['a'] = 1.06;
			fees[shop]['card'][10]['b'] = 0;
			fees[shop]['card'][20] = {};
			fees[shop]['card'][20]['a'] = 1.06;
			fees[shop]['card'][20]['b'] = 0;
			fees[shop]['card'][30] = {};
			fees[shop]['card'][30]['a'] = 1.06;
			fees[shop]['card'][30]['b'] = 0;
			fees[shop]['card'][infinity] = {};
			fees[shop]['card'][infinity]['a'] = 1.06;
			fees[shop]['card'][infinity]['b'] = 0;
		}

		if (shop == 224 )
		{
			fees[shop]['paypal'][10] = {};
			fees[shop]['paypal'][10]['a'] = 1.074;
			fees[shop]['paypal'][10]['b'] = 0.75;
			fees[shop]['paypal'][20] = {};
			fees[shop]['paypal'][20]['a'] = 1.074;
			fees[shop]['paypal'][20]['b'] = 0.75;
			fees[shop]['paypal'][30] = {};
			fees[shop]['paypal'][30]['a'] = 1.074;
			fees[shop]['paypal'][30]['b'] = 0.75;
			fees[shop]['paypal'][infinity] = {};
			fees[shop]['paypal'][infinity]['a'] = 1.074;
			fees[shop]['paypal'][infinity]['b'] = 0.75;
			fees[shop]['card'][10] = {};
			fees[shop]['card'][10]['a'] = 1.04;
			fees[shop]['card'][10]['b'] = 0.51;
			fees[shop]['card'][20] = {};
			fees[shop]['card'][20]['a'] = 1.04;
			fees[shop]['card'][20]['b'] = 0.51;
			fees[shop]['card'][30] = {};
			fees[shop]['card'][30]['a'] = 1.04;
			fees[shop]['card'][30]['b'] = 0.51;
			fees[shop]['card'][infinity] = {};
			fees[shop]['card'][infinity]['a'] = 1.04;
			fees[shop]['card'][infinity]['b'] = 0.51;
		}

		if (shop == 176 )
		{
			fees[shop]['paypal'][10] = {};
			fees[shop]['paypal'][10]['a'] = 1.010437;
			fees[shop]['paypal'][10]['b'] = 0;
			fees[shop]['paypal'][20] = {};
			fees[shop]['paypal'][20]['a'] = 1.010437;
			fees[shop]['paypal'][20]['b'] = 0;
			fees[shop]['paypal'][30] = {};
			fees[shop]['paypal'][30]['a'] = 1.010437;
			fees[shop]['paypal'][30]['b'] = 0;
			fees[shop]['paypal'][infinity] = {};
			fees[shop]['paypal'][infinity]['a'] = 1.010437;
			fees[shop]['paypal'][infinity]['b'] = 0;
			fees[shop]['card'][10] = {};
			fees[shop]['card'][10]['a'] = 1.010437;
			fees[shop]['card'][10]['b'] = 0;
			fees[shop]['card'][20] = {};
			fees[shop]['card'][20]['a'] = 1.010437;
			fees[shop]['card'][20]['b'] = 0;
			fees[shop]['card'][30] = {};
			fees[shop]['card'][30]['a'] = 1.010437;
			fees[shop]['card'][30]['b'] = 0;
			fees[shop]['card'][infinity] = {};
			fees[shop]['card'][infinity]['a'] = 1.010437;
			fees[shop]['card'][infinity]['b'] = 0;
		}

		if (shop == 400 )
		{
			fees[shop]['paypal'][5] = {};
			fees[shop]['paypal'][5]['a'] = 1;
			fees[shop]['paypal'][5]['b'] = 0;
			fees[shop]['paypal'][10] = {};
			fees[shop]['paypal'][10]['a'] = 1;
			fees[shop]['paypal'][10]['b'] = 0;
			fees[shop]['paypal'][20] = {};
			fees[shop]['paypal'][20]['a'] = 1;
			fees[shop]['paypal'][20]['b'] = 0;
			fees[shop]['paypal'][30] = {};
			fees[shop]['paypal'][30]['a'] = 1;
			fees[shop]['paypal'][30]['b'] = 0;
			fees[shop]['paypal'][infinity] = {};
			fees[shop]['paypal'][infinity]['a'] = 1;
			fees[shop]['paypal'][infinity]['b'] = 0;
			fees[shop]['card'][10] = {};
			fees[shop]['card'][10]['a'] = 1;
			fees[shop]['card'][10]['b'] = 0;
			fees[shop]['card'][20] = {};
			fees[shop]['card'][20]['a'] = 1;
			fees[shop]['card'][20]['b'] = 0;
			fees[shop]['card'][30] = {};
			fees[shop]['card'][30]['a'] = 1;
			fees[shop]['card'][30]['b'] = 0;
			fees[shop]['card'][infinity] = {};
			fees[shop]['card'][infinity]['a'] = 1;
			fees[shop]['card'][infinity]['b'] = 0;
		}

	}
	return fees;
}