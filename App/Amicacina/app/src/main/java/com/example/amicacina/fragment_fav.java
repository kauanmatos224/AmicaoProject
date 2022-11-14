package com.example.amicacina;

import android.annotation.SuppressLint;
import android.content.Intent;
import android.database.Cursor;
import android.os.Bundle;

import androidx.fragment.app.Fragment;

import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.AdapterView;
import android.widget.GridView;
import android.widget.TextView;

import java.util.ArrayList;
import java.util.List;

public class fragment_fav extends Fragment {

    GridView gridviewFav;
    TextView txtFav;

    public fragment_fav() {
        // Required empty public constructor
    }


    @SuppressLint({"Range", "MissingInflatedId"})
    @Override

    public View onCreateView(LayoutInflater inflater, ViewGroup container,
                             Bundle savedInstanceState) {
        View view = inflater.inflate(R.layout.fragment_fav, container, false);

        gridviewFav = (GridView) view.findViewById(R.id.GridViewFav);
        txtFav = (TextView) view.findViewById(R.id.txtFavo);
        ArrayList<GridModel> gridModelArrayList = new ArrayList<GridModel>();

        GridAdapter adapter = new GridAdapter(getContext(), gridModelArrayList);
        DatabaseController db = new DatabaseController(getContext());
        Cursor cursor = db.retrieveFavPets();

        if(cursor.getCount()==0){
            MainActivity.null_fav=true;
        }
        else{
            MainActivity.null_fav=false;
        }
        for(int i=0; i<cursor.getCount(); i++) {
            gridModelArrayList.add(new GridModel(
                    cursor.getString(cursor.getColumnIndex("id")),
                    cursor.getString(cursor.getColumnIndex("nome")),
                    cursor.getString(cursor.getColumnIndex("raca")),
                    cursor.getString(cursor.getColumnIndex("nascimento")),
                    cursor.getString(cursor.getColumnIndex("idade")),
                    cursor.getString(cursor.getColumnIndex("status")),
                    cursor.getString(cursor.getColumnIndex("genero")),
                    cursor.getString(cursor.getColumnIndex("porte")),
                    cursor.getString(cursor.getColumnIndex("comportamento")),
                    cursor.getString(cursor.getColumnIndex("foto"))
            ));

            cursor.moveToNext();
        }
        gridviewFav.setAdapter(adapter);

        gridviewFav.setOnItemClickListener(new GridView.OnItemClickListener(){
            @Override
            public void onItemClick(AdapterView parent, View view, int position, long id) {
                // TODO Auto-generated method stub
                // Toast.makeText(getContext(), "Imagem: "+(position+1), Toast.LENGTH_SHORT).show();

                MainActivity.pos = position;
                MainActivity.from_fav=true;
                Intent intent = new Intent();
                intent.setClass(getActivity(), activity_details.class);
                getActivity().startActivity(intent);
                getActivity().finish();
            }

        });

        TextView txtFav = (TextView) view.findViewById(R.id.txtFavo);
        if(MainActivity.null_fav){
            txtFav.setVisibility(View.VISIBLE);
        }
        else{
            txtFav.setVisibility(View.INVISIBLE);
        }

        return view;
    }
}