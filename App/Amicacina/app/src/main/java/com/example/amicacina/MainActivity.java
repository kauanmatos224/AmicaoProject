package com.example.amicacina;

import androidx.annotation.NonNull;
import androidx.appcompat.app.ActionBar;
import androidx.appcompat.app.ActionBarDrawerToggle;
import androidx.appcompat.app.AppCompatActivity;
import androidx.drawerlayout.widget.DrawerLayout;
import androidx.fragment.app.Fragment;

import android.content.Intent;
import android.graphics.Color;
import android.graphics.drawable.ColorDrawable;
import android.os.Bundle;
import android.view.MenuItem;
import android.view.View;
import android.widget.AdapterView;
import android.widget.ListView;

import com.google.android.material.bottomnavigation.BottomNavigationView;
import com.google.gson.JsonArray;
import com.google.gson.JsonObject;
import com.koushikdutta.async.future.FutureCallback;
import com.koushikdutta.ion.Ion;

//http://amicao.herokuapp.com/application_retrieve/pets
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
    public static Fragment selectedFragment = null;

    public static int pos;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_main);

        ActionBar actionBar = getSupportActionBar();
        actionBar.hide();

        DatabaseController db = new DatabaseController(MainActivity.this);
        String url = "https://amicao.herokuapp.com/application_retrieve/pets";
        db.dropAndCreateTable();
        Ion.with (MainActivity.this)
                .load (url)
                .asJsonArray()
                .setCallback ( new FutureCallback<JsonArray>() {
                    @Override
                    public void onCompleted(Exception e, JsonArray result) {
                        for (int i = 0; i < result.size(); i++) {
                            JsonObject res_json = result.get(i).getAsJsonObject();
                            db.insertData(
                                    res_json.get("id").getAsInt(),
                                    res_json.get("nome").getAsString(),
                                    res_json.get("img_path").getAsString(),
                                    res_json.get("comportamento").getAsString(),
                                    res_json.get("status").getAsString(),
                                    res_json.get("raca").getAsString(),
                                    res_json.get("porte").getAsString(),
                                    res_json.get("endereco").getAsString(),
                                    res_json.get("nascimento").getAsString(),
                                    "false",
                                    res_json.get("idade").getAsString(),
                                    res_json.get("genero").getAsString()
                            );
                            getSupportFragmentManager().beginTransaction()
                                    .replace(R.id.fragment_layout,new fragment_home()).commit();
                        }

                    }
                });

        //bottom nav
        BottomNavigationView btnNav = findViewById(R.id.bottomNavigationview);
        btnNav.setOnNavigationItemSelectedListener(navListener);

        //setting home fragment as main fragment
        getSupportFragmentManager().beginTransaction()
                .replace(R.id.fragment_layout,new fragment_home()).commit();

    }

    //listener nav bar
    public BottomNavigationView.OnNavigationItemSelectedListener navListener = new
            BottomNavigationView.OnNavigationItemSelectedListener() {
                @Override
                public boolean onNavigationItemSelected(@NonNull MenuItem item) {

                    switch (item.getItemId()){
                        case R.id.home:
                            selectedFragment = new fragment_home();
                            break;

                        case R.id.fav:
                            selectedFragment = new fragment_fav();
                            break;

                        case R.id.search:
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