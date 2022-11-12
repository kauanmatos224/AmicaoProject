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
import android.util.Log;
import android.view.MenuItem;
import android.view.View;
import android.widget.AdapterView;
import android.widget.ListView;

import com.google.android.material.bottomnavigation.BottomNavigationView;
import com.google.gson.JsonArray;
import com.google.gson.JsonNull;
import com.google.gson.JsonObject;
import com.koushikdutta.async.future.FutureCallback;
import com.koushikdutta.ion.Ion;

//http://amicao.herokuapp.com/application_retrieve/pets
public class MainActivity extends AppCompatActivity {

    public static final String GET_DATA_URL = "https://amicao.herokuapp.com/application_retrieve/pets";
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
    public static int id_pet;
    public static int pos;
    public static String user_toast_message;
    public static Boolean updated_pets;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_main);

        ActionBar actionBar = getSupportActionBar();
        actionBar.hide();

        DatabaseController db = new DatabaseController(MainActivity.this);

        Ion.with (MainActivity.this)
                .load (GET_DATA_URL)
                .asJsonArray()
                .setCallback ( new FutureCallback<JsonArray>() {
                    @Override
                    public void onCompleted(Exception e, JsonArray result) {
                        for (int i = 0; i < result.size(); i++) {
                            JsonObject res_json = result.get(i).getAsJsonObject();
                            Log.d("data", res_json.get("id").getAsString());
                            String comportamentox, nascimentox;

                            if(res_json.get("comportamento")==JsonNull.INSTANCE){
                                comportamentox="";
                            }
                            else{
                                comportamentox=res_json.get("comportamento").getAsString();
                            }
                            if(res_json.get("nascimento")==JsonNull.INSTANCE){
                                nascimentox="";
                            }else{
                                nascimentox=res_json.get("nascimento").getAsString();

                            }


                            db.syncData(
                                    res_json.get("id").getAsInt(),
                                    res_json.get("nome").getAsString(),
                                    res_json.get("img_path").getAsString(),
                                    comportamentox,
                                    res_json.get("status").getAsString(),
                                    res_json.get("raca").getAsString(),
                                    res_json.get("porte").getAsString(),
                                    res_json.get("endereco").getAsString(),
                                    nascimentox,
                                    "false",
                                    res_json.get("idade").getAsString(),
                                    res_json.get("genero").getAsString()
                            );
                            getSupportFragmentManager().beginTransaction()
                                    .replace(R.id.fragment_layout,new fragment_home()).commit();
                            Ion.getDefault(MainActivity.this).cancelAll(MainActivity.this);
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