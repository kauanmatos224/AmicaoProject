package com.example.amicacina;

import androidx.annotation.NonNull;
import androidx.appcompat.app.AppCompatActivity;
import androidx.fragment.app.Fragment;

import android.os.Bundle;
import android.view.MenuItem;

import com.google.android.material.bottomnavigation.BottomNavigationView;

public class MainActivity extends AppCompatActivity {

    public static String[] id = new String[7];
    public static int[] foto = new int[7];
    public static String[] nome = new String[7];
    public static String[] raca = new String[7];
    public static String[] nasc = new String[7];
    public static String[] idad = new String[7];
    public static String[] stat = new String[7];
    public static String[] gene = new String[7];
    public static String[] port = new String[7];
    public static String[] comp = new String[7];
    public static Boolean[] fav = new Boolean[7];

    public static int pos;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_main);

        fav[0] = false;
        fav[1] = false;
        fav[2] = false;
        fav[3] = false;
        fav[4] = false;
        fav[5] = false;
        fav[6] = false;


        //bottom nav
        BottomNavigationView btnNav = findViewById(R.id.bottomNavigationview);
        btnNav.setOnNavigationItemSelectedListener(navListener);

        //setting home fragment as main fragment
        getSupportFragmentManager().beginTransaction()
                .replace(R.id.fragment_layout,new fragment_home()).commit();
    }

    //listener nav bar
    private BottomNavigationView.OnNavigationItemSelectedListener navListener = new
            BottomNavigationView.OnNavigationItemSelectedListener() {
                @Override
                public boolean onNavigationItemSelected(@NonNull MenuItem item) {
                    Fragment selectedFragment = null;
                    switch (item.getItemId()){
                        case R.id.home:
                            selectedFragment = new fragment_home();
                            break;

                        case R.id.fav:
                            selectedFragment = new fragment_fav();
                            break;

                        case R.id.social:
                            selectedFragment = new fragment_search();
                            break;
                    }

                    //begin transaction
                    getSupportFragmentManager().beginTransaction()
                            .replace(R.id.fragment_layout
                                    ,selectedFragment).commit();

                    return true;
                }
            };

}